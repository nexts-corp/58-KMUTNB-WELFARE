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
        $daoWelfare = new Welfare();
        $obj = $this->datacontext->getObject($daoWelfare);
        $obj = $this->common->afterGet($obj);
//        if (count($obj) > 0) {
//            foreach ($obj as $key => $value) {
//                if ($value->dateStart != "") {
//                    $dsY = $value->dateStart->format('Y') + 543;
//                    $obj[$key]->dateStart = $value->dateStart->format('d-m-' . $dsY);
//                }
//                if ($value->dateEnd != "") {
//                    $deY = $value->dateEnd->format('Y') + 543;
//                    $obj[$key]->dateEnd = $value->dateEnd->format('d-m-' . $deY);
//                }
//            }
//        }

        foreach ($obj as $key => $value) {

            if ($obj[$key]->resetTime == "12") {
                $obj[$key]->resetTime = "ทุก 1 ปี";
            } elseif ($obj[$key]->resetTime == "0") {
                $obj[$key]->resetTime = "ครั้งเดียว";
            } elseif ($obj[$key]->resetTime == "6") {
                $obj[$key]->resetTime = "ทุก 6 เดือน";
            }
        }


        $view->datas = $obj;
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

        $view->position = $this->taxonomy->getPCode("position");

        $view->department = $this->taxonomy->getPCode("department");

        $view->faculty = $this->taxonomy->getPCode("faculty");

        $view->userType = $this->taxonomy->getPCode("userType");
        
        return $view;
    }

    public function memberLists() {

        $view = new CJView("admin/member/lists", CJViewType::HTML_VIEW_ENGINE);
        $query = "SELECT *,IFNULL(academic1,titleName1) title "
                . "FROM v_fullmember ";
        $member = $this->datacontext->pdoQuery($query);

        $i = 1;
        foreach ($member as $key => $value) {
            $member[$key]["rowNo"] = $i++;
        }

        $view->datasMember = $member;

        return $view;
    }

    public function rightList() {

        $memberId = $this->getRequest()->memberId;

        $view = new CJView("admin/member/rightLists", CJViewType::HTML_VIEW_ENGINE);
        $query = "SELECT *,IFNULL(academic1,titleName1) title "
                . "FROM v_fullmember where memberId=:memberId";
        $param = array("memberId" => $memberId);
        $member = $this->datacontext->pdoQuery($query, $param);
        $view->datasMember = $member;
        $view->memberId = $memberId;

        return $view;
    }

    public function reportWelfare() {

        $welfareId = $this->getRequest()->welfareId;
        $view = new CJView("admin/report/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare = new WelfareService();
        $objWelfare = $daoWelfare->get($welfareId);
        
        $employee = array();
        $view->datasDetails=$objWelfare->details;
       
       foreach ($objWelfare->details as $key => $value) {
            
            array_push($employee, $daoWelfare->preview($value->conditions));
            
        }
//         foreach ($employee as $key => $value) {
//                $view->datasMember = $value;
//                
//            }


        return $view;
    }

}
