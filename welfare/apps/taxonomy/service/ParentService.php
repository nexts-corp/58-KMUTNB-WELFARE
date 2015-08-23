<?php

namespace apps\taxonomy\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\taxonomy\interfaces\IParentService;

class ParentService extends CServiceBase implements IParentService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($taxonomy) {
        //return $taxonomy;
        return $this->datacontext->saveObject($taxonomy);
    }

    public function update($taxonomy) {
        return $this->datacontext->updateObject($taxonomy);
    }

    public function delete($taxonomy) {
        return $this->datacontext->removeObject($taxonomy);
    }

}
