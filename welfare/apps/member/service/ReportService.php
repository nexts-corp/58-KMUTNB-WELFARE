<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;
use apps\member\interfaces\IReportService;
use apps\user\entity\User;

class ReportService extends CServiceBase implements IReportService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext("default");
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
    }

    public function reportList() {

        $view = new CJView("admin/report/listReport", CJViewType::HTML_VIEW_ENGINE);
        
         $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
        $searchName = $this->getRequest()->searchName;
        $filterCode = $this->getRequest()->filterCode;
        $filtervalue = $this->getRequest()->filtervalue;
        $datafilter = $this->getRequest();

        

        $param = array();
        $sql = "select mem1 "
                . "FROM apps\\member\\model\\FullMember mem1 ";
        $view->lists = $this->datacontext->getObject($sql, $param); //กรณีที่ไม่ได้ search
        
        
        return $view;
    }

}
