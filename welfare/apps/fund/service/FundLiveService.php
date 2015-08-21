<?php
namespace apps\fund\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\fund\interfaces\IFundLiveService;

class FundLiveService extends CServiceBase implements IFundLiveService{
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function viewList() {
        $view = new CJView("fundlive/list", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

    public function viewAdd() {
        $view = new CJView("fundlive/add", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

    public function viewListdetail() {
        $view = new CJView("fundlive/detail", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

    public function viewAdddetail() {
        $view = new CJView("fundlive/adddetail", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

}
