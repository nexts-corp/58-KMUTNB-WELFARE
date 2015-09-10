<?php

namespace apps\taxonomy\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\taxonomy\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    private function getNewCode() {
        $tax = new \apps\taxonomy\entity\Taxonomy();
        $data = $this->datacontext->getObject($tax);
        if (count($data) == 0) {
            $id = "000001";
        } else {
            $id = intval($data[count($data) - 1]->id) + 1;
            $id2 = "";
            for ($i = 0; $i < (6 - strlen($id)); $i++) {
                $id2 .= "0";
            }
            $id = $id2 . $id;
        }
        return $id;
    }

    public function add() {
        $view = new CJView("add", CJViewType::HTML_VIEW_ENGINE);
        $view->id = $this->getNewCode();

        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->parent = "Y";
        $parent = $this->datacontext->getObject($tax);

        $view->parent = $parent;
        return $view;
    }

    public function edit($id) {
        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->id = $id;
        $view = new CJView("edit", CJViewType::HTML_VIEW_ENGINE);
        $view->lists = $this->datacontext->getObject($tax)[0];
        
        $parent = new \apps\taxonomy\entity\Taxonomy();
        $parent->parent = 'Y';
        $view->parent = $this->datacontext->getObject($parent);
        
        return $view;
    }

    public function lists() {
        $view = new CJView("lists", CJViewType::HTML_VIEW_ENGINE);
        $parentId = $this->getRequest()->parentId;
        if ($parentId != "" && $parentId != "0") {
            $child = new \apps\taxonomy\entity\Taxonomy();
            $child->parentId = $parentId;

            $view->child = $this->datacontext->getObject($child);
        } else {
            $child = "select t from apps\\taxonomy\\entity\\Taxonomy t";
            //  . " where t.parentId != '0'";
            $view->child = $this->datacontext->getObject($child);
        }
        $parent = "select t from apps\\taxonomy\\entity\\Taxonomy t "
                . "where t.parent = 'Y' "
                . "order by t.pCode,t.code";
        $view->parent = $this->datacontext->getObject($parent);

        return $view;
    }

}
