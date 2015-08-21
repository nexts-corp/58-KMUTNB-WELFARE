<?php
namespace apps\ManagementFund\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use apps\ManagementFund\interfaces\IFundService;
class FundService extends CServiceBase implements IFundService{
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }
    
    public function viewList() {
        $view = new CJView("fund/list", CJViewType::HTML_VIEW_ENGINE);
//        $filter = new AcademicPositions();
//        $dao_department = $this->datacontext->getObject($filter);
//        $view->cuss = $dao_department;
        return $view;
    }

}
