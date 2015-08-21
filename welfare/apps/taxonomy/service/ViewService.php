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

    public function mainLists() {
        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->parentCode = 0;
        $data = $this->datacontext->getObject($tax);
        $view = new CJView("main/lists", CJViewType::HTML_VIEW_ENGINE);
        $view->lists = $data;
        return $view;
    }

    public function mainAdd() {
        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->parentCode = 0;
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
        $view = new CJView("main/add", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $code;
        return $view;
    }

    public function mainEdit($code) {
        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->code = $code;
        $view = new CJView("main/edit", CJViewType::HTML_VIEW_ENGINE);
        $view->lists = $this->datacontext->getObject($tax)[0];
        return $view;
    }

}
