<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\insurance\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function ssoAdd() {
        $view = new CJView("sso/add", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function ssoEdit() {
        $view = new CJView("sso/edit", CJViewType::HTML_VIEW_ENGINE);

        return $view;
        
    }

    public function ssoLists() {
        $view = new CJView("sso/lists", CJViewType::HTML_VIEW_ENGINE);
        $sso = new SSOService();
        $view->lists = $sso->lists();
        return $view;
        
    }
      public function ssoUpload() {
        $view = new CJView("sso/upload", CJViewType::HTML_VIEW_ENGINE);

        return $view;
        
    }

}
