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
            $code = "000001";
        } else {
            $code = intval($data[count($data) - 1]->code) + 1;
            $code2 = "";
            for ($i = 0; $i < (6 - strlen($code)); $i++) {
                $code2 .= "0";
            }
            $code = $code2 . $code;
        }
        return $code;
    }

    public function parentLists() {
        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->parentCode = 0;
        $data = $this->datacontext->getObject($tax);
        $view = new CJView("parent/lists", CJViewType::HTML_VIEW_ENGINE);
        $view->lists = $data;
        return $view;
    }

    public function parentAdd() {

        $view = new CJView("parent/add", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getNewCode();
        return $view;
    }

    public function parentEdit($code) {
        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->code = $code;
        $view = new CJView("parent/edit", CJViewType::HTML_VIEW_ENGINE);
        $view->lists = $this->datacontext->getObject($tax)[0];
        return $view;
    }

    public function childAdd() {
        $view = new CJView("child/add", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getNewCode();

        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->parentCode = "0";
        $parent = $this->datacontext->getObject($tax);

        $view->parent = $parent;
        return $view;
    }

    public function childEdit($code) {
        
    }

    public function childLists() {
        $view = new CJView("child/lists", CJViewType::HTML_VIEW_ENGINE);
        $parentCode = $this->getRequest()->parentCode;
        if ($parentCode != "" && $parentCode != "0") {
            $child = new \apps\taxonomy\entity\Taxonomy();
            $child->parentCode = $parentCode;
            $view->child = $this->datacontext->getObject($child);
        } else {
            $sql = "select t from apps\\taxonomy\\entity\\Taxonomy t"
                    . " where t.parentCode != '0'";
            $view->child = $this->datacontext->getObject($sql);
        }
        $parent = new \apps\taxonomy\entity\Taxonomy();
        $parent->parentCode = "0";
        $view->parent = $this->datacontext->getObject($parent);

        return $view;
    }

}
