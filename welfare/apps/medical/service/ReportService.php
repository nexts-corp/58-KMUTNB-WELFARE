<?php
namespace apps\medical\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use apps\medical\interfaces\IReport;
class Report extends CServiceBase implements IReport {
    
     public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }
    
    public function viewList() {
        $view = new CJView("report/list", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
