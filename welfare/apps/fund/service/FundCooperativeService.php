<?php
namespace apps\fund\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\fund\interfaces\IFundCooperativeService;

class FundCooperativeService extends CServiceBase implements IFundCooperativeService{
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }
    
    public function viewList() {
        $view = new CJView("cooperative/list", CJViewType::HTML_VIEW_ENGINE);
        return  $view;
    }

    public function viewAdd() {
        $view = new CJView("cooperative/add", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

    public function viewAdddetail() {
        $view = new CJView("cooperative/adddetail", CJViewType::HTML_VIEW_ENGINE);
        return  $view;
    }

    public function viewListdetail() {
        $view = new CJView("cooperative/detail", CJViewType::HTML_VIEW_ENGINE);
        return  $view;
    }

}
