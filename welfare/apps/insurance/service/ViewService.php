<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\insurance\interfaces\IViewService;
use apps\taxonomy\entity\Taxonomy;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function ssoAdminAdd() {
        $view = new CJView("sso/admin/add", CJViewType::HTML_VIEW_ENGINE);
        $taxTitleName = new Taxonomy();
        $taxTitleName->pCode = "titleName";
        
        return $view;
    }

    public function ssoAdminEdit() {
        $view = new CJView("sso/admin/edit", CJViewType::HTML_VIEW_ENGINE);

        return $view;
        
    }

    public function ssoAdminLists() {
        $view = new CJView("sso/admin/lists", CJViewType::HTML_VIEW_ENGINE);
        $sso = new SSOService();
        $view->lists = $sso->lists();
        return $view;
        
    }
      

}
