<?php
namespace apps\ManagementFund\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\ManagementFund\interfaces\IFundretireService;
class FundretireService extends CServiceBase implements IFundretireService{
   
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }
    
    public function viewAdd() {
        $view = new CJView("fundretire/add", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

    public function viewList() {
        $view = new CJView("fundretire/list", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

    public function viewAdddetail() {
        $view = new CJView("fundretire/adddetail", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

    public function viewListdetail() {
        $view = new CJView("fundretire/detail", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

//put your code here
}
