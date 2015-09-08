<?php

namespace apps\menu\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\menu\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function header() {
        $view = new CJView("header", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function admin() {
        $view = new CJView("menu/admin", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function member() {

        $view = new CJView("menu/member", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getCurrentUser()->code;
        return $view;
    }

    public function department() {
        
        $view = new CJView("menu/department", CJViewType::HTML_VIEW_ENGINE);
        
        return $view;
    }

    public function faculty() {
        
        $view = new CJView("menu/faculty", CJViewType::HTML_VIEW_ENGINE);
       // $view->code = $this->getCurrentUser()->code;
        return $view;
    }

}
