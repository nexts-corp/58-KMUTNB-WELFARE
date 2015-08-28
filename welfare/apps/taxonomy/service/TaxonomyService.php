<?php

namespace apps\taxonomy\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\taxonomy\interfaces\ITaxonomyService;
use apps\taxonomy\entity\Taxonomy;

class TaxonomyService extends CServiceBase implements ITaxonomyService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($taxonomy) {
//return $taxonomy;
        return $this->datacontext->saveObject($taxonomy);
    }

    public function update($taxonomy) {
        $return = true;
        $tax = new Taxonomy();
        $tax->id = $taxonomy->id;
        $dataOld = $this->datacontext->getObject($tax)[0];
        if (($dataOld->parent == 'Y') && ($taxonomy->parent == 'Y')) {
            if ($taxonomy->code != $dataOld->code) {
                $child = new Taxonomy();
                $child->pCode = $dataOld->code;
                $dataChild = $this->datacontext->getObject($child);
                if (count($dataChild) > 0) {
                    foreach ($dataChild as $keyC => $valueC) {
                        $dataChild[$keyC]->pCode = $taxonomy->code;
                    }
                    $return = $this->datacontext->updateObject($dataChild);
                }
            }
            $return = $this->datacontext->updateObject($taxonomy);
        }
        if (($dataOld->parent == 'Y') && ($taxonomy->parent == 'N')) {
            $child = new Taxonomy();
            $child->pCode = $dataOld->code;
            $dataChild = $this->datacontext->getObject($child);
            if (count($dataChild) > 0) {
                $return = "delChildBefore";
            } else {
                $return = $this->datacontext->updateObject($taxonomy);
            }
        }
        if (($dataOld->parent == 'N') && ($taxonomy->parent == 'N')) {
            $return = $this->datacontext->updateObject($taxonomy);
        }
        return $return;
// return $this->datacontext->updateObject($taxonomy);
    }

    public function delete($taxonomy) {
        $data = $this->datacontext->getObject($taxonomy)[0];
        $return = true;
        if ($data->parent == 'Y') {
            $child = new Taxonomy();
            $child->pCode = $data->code;
            $dataChild = $this->datacontext->getObject($child);
            if (count($dataChild) > 0) {
                $return = "delChildBefore";
            } else {
                $return = $this->datacontext->removeObject($data);
            }
        }
        if ($data->parent == 'N') {
            $return = $this->datacontext->removeObject($data);
        }
        return $return;
    }

    public function getParent() {
        $tax = new Taxonomy();
        $tax->parent = "Y";
        return $this->datacontext->getObject($tax);
    }

}
