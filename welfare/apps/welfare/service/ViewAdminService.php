<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\taxonomy\service\TaxonomyService;
use apps\common\service\CommonService;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IViewAdminService;
use apps\welfare\entity\Welfare;
use apps\welfare\entity\Details;
use apps\welfare\entity\Conditions;
use apps\welfare\entity\History;
use apps\welfare\service\WelfareService;

class ViewAdminService extends CServiceBase implements IViewAdminService {

    public $datacontext;
    public $taxonomy;
    public $common;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new TaxonomyService();
        $this->common = new CommonService();
    }

    public function welfareLists() {
        $view = new CJView("admin/welfare/lists", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function welfareAdd() {
        $view = new CJView("admin/welfare/add", CJViewType::HTML_VIEW_ENGINE);
        $view->unit = $this->taxonomy->getPCode("unit");
        return $view;
    }

    public function welfareEdit() {
        $view = new CJView("admin/welfare/edit", CJViewType::HTML_VIEW_ENGINE);
        $welfareId = $this->getRequest()->welfareId;
        $wel = new WelfareService();
        $view->welfare = $wel->get($welfareId);
        $view->unit = $this->taxonomy->getPCode("unit");
        return $view;
    }

    public function approveLists() {

        $view = new CJView("admin/approve/lists", CJViewType::HTML_VIEW_ENGINE);

        $view->academic = $this->taxonomy->getPCode("academic");

        $view->gender = $this->taxonomy->getPCode("gender");

        $view->employeeType = $this->taxonomy->getPCode("employeeType");


        $view->department = $this->taxonomy->getPCode("department");

        $view->faculty = $this->taxonomy->getPCode("faculty");


        return $view;
    }

    public function memberLists() {

        $view = new CJView("admin/member/lists", CJViewType::HTML_VIEW_ENGINE);

        $view->academic = $this->taxonomy->getPCode("academic");

        $view->gender = $this->taxonomy->getPCode("gender");

        $view->employeeType = $this->taxonomy->getPCode("employeeType");


        $view->department = $this->taxonomy->getPCode("department");

        $view->faculty = $this->taxonomy->getPCode("faculty");



        return $view;
    }

    public function rightList() {

        $memberId = $this->getRequest()->memberId;

        $view = new CJView("admin/member/rightLists", CJViewType::HTML_VIEW_ENGINE);
        $query = "SELECT mb "
                . "FROM apps\\member\\model\\Fullmember mb where mb.memberId=:memberId";
        $param = array("memberId" => $memberId);
        $member = $this->datacontext->getObject($query, $param);
        $view->datasMember = $member;
        $view->memberId = $memberId;



        return $view;
    }

    public function reportWelfare() {

        $welfareId = $this->getRequest()->welfareId;
        $view = new CJView("admin/welfare/right/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare = new WelfareService();
        $objWelfare = $daoWelfare->get($welfareId);

        $employee = array();
        $view->datasDetails = $objWelfare->details;

        foreach ($objWelfare->details as $key => $value) {

            array_push($employee, $daoWelfare->preview($value->conditions));
        }
//         foreach ($employee as $key => $value) {
//                $view->datasMember = $value;
//                
//            }

        $view->welfareId = $welfareId;
        $view->datas = $objWelfare;

        return $view;
    }

    public function reportsAp() {
        $view = new CJView("admin/report/lists", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function approveAdd() {

        $view = new CJView("admin/approve/add", CJViewType::HTML_VIEW_ENGINE);
        $sqlWel = "select r from apps\\welfare\\entity\\Welfare r "
                . "where r.code is null and r.statusActive = 'Y'";

        $obj = $this->datacontext->getObject($sqlWel);
        $obj = $this->common->afterGet($obj);
        $view->dataslist=$obj;
        
        return $view;
    }

}
