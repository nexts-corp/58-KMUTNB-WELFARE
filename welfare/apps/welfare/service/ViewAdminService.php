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

        $sqlApprove = "SELECT ap.historyId,ap.statusApprove,ap.welfareId,ap.memberId,ap.detailsId,"
                . " IFNULL(mb.academic1,mb.titleName1) title  , mb.memberId , "
                . " mb.fname , mb.lname , "
                . "wf.name,wf.description,"
                . "wfc.description as wfcdetails,wfc.quantity "
                . " FROM welfarehistory ap Left Join v_fullmember mb "
                . " on ap.memberId = mb.memberId "
                . "Left Join welfare wf "
                . "on ap.welfareId = wf.welfareId "
                . "Left Join welfaredetails wfc "
                . "on ap.detailsId=wfc.detailsId "
                . " where ap.statusApprove='P' ";


        $objApprove = $this->datacontext->pdoQuery($sqlApprove);



        $i = 1;
        if ($objApprove != "") {


            foreach ($objApprove as $key => $value) {

                $objApprove[$key]["rowNo"] = $i++;
            }
        }

        $view->dataApprove = $objApprove;


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

    public function checkWelfare() {

        $memberId = $this->getRequest()->memberId;
        $mb = new \apps\member\service\MemberService();
        $member = $mb->find("memberId", $memberId)[0];
//        $employeeTypeId = $member->employeeTypeId;

        $sqlDetails = "select wfc.detailsId  from welfareconditions wfc
                join welfaredetails wfd on wfc.detailsId = wfd.detailsId
                join welfare wf on wf.welfareId = wfd.welfareId
                where wfc.fieldMap = :fieldmap
                and wfc.valuex in 
                ( 
                   select employeeTypeId from v_fullmember where memberId =:memberId
                )
                and wfd.statusActive = 'Y' and wf.statusActive = 'Y' ";

        $param = array("memberId" => $memberId, "fieldmap" => "employeeTypeId");
        $details = $this->datacontext->pdoQuery($sqlDetails, $param);

        $matchId = array();
        foreach ($details as $valueId) {
            $condition = new \apps\welfare\entity\Conditions();
            $condition->detailsId = $valueId['detailsId'];
            $dataCondition = $this->datacontext->getObject($condition);

            $query = "SELECT * "
                    . "FROM v_fullmember "
                    . "where ";
            $field = array();
            foreach ($dataCondition as $key => $value) {
                $index = 0;
                if (!empty($field[$value->fieldMap])) {
                    $index = count($field[$value->fieldMap]);
                }
                $field[$value->fieldMap][$index]['operations'] = $value->operations;
                $field[$value->fieldMap][$index]['valuex'] = $value->valuex;
            }

            $where = "";
            foreach ($field as $key => $value) {
                $count = count($value);
                $sql = "";
                if ($where != "") {
                    $sql .= " AND ";
                }
                if ($count > 1 && $key == 0) {
                    $sql .= " ( ";
                }

                foreach ($value as $key2 => $value2) {

                    if ($sql != "" && $key2 > 0) {
                        if ($value2['operations'] == "=" || $value2['operations'] == "!=") {
                            $sql .= " OR ";
                        } else {
                            $sql .= " AND ";
                        }
                    }
                    if (strpos($value2['valuex'], "-") && ($key == "dob" || $key == "workStartDate" || $key == "workEndDate")) {
                        $sql .= " " . $key . " " . $value2['operations'] . " '" . $value2['valuex'] . "' ";
                    } elseif (!strpos($value2['valuex'], "-") && ($key == "dob" || $key == "workStartDate" || $key == "workEndDate")) {
                        $sql .= " TIMESTAMPDIFF(YEAR,'" . $member->$key . "', CURDATE()) " . $value2['operations'] . " " . $value2['valuex'] . " ";
                    } else {
                        $sql .= " " . $key . " " . $value2['operations'] . " '" . $value2['valuex'] . "' ";
                    }
                }
                if ($count > 1) {
                    $sql .= " ) ";
                }
                $where .= $sql;
            }
            $detailsId = $valueId['detailsId'];
            $sql = $query . " " . $where . " and memberId = :memberId ";
            $dataCheck = $this->datacontext->pdoQuery($sql, array("memberId" => $memberId));
            if (count($dataCheck) > 0) {
                array_push($matchId, $detailsId);
            }
        }

        $id = "";
        foreach ($matchId as $key => $value) {
            if ($key != 0) {
                $id .= "," . $value;
            } else {
                $id .= $value;
            }
        }



        $sqlDetails = "SELECT wfdt.detailsId as detailsId,wfdt.quantity,wfdt.returnTypeId,wfdt.description as dcpDetails , "
                . "wfdt.welfareId,  "
                . "rt.value1 As returntType,rt.id,"
                . "wf.name,wf.statusActive,wf.description  "
                . " FROM  welfaredetails wfdt "
                . "Left JOIN  welfare wf "
                . "on wfdt.welfareId = wf.welfareId "
                . "Left JOIN taxonomy rt  "
                . "on wfdt.returnTypeId = rt.id "
                . "where detailsId in ( " . $id . " )";


        $objDetailsId = $this->datacontext->pdoQuery($sqlDetails);


        $sqlHistory = "SELECT htr.historyId,htr.detailsId,htr.statusApprove "
                . "From welfarehistory htr where detailsId in (" . $id . ") and memberId=:memberId Order By htr.historyId desc ";

        $param1 = array("memberId" => $memberId);

        $objHistory = $this->datacontext->pdoQuery($sqlHistory, $param1);

        if (!empty($objHistory)) {
            foreach ($objHistory as $key => $value) {

                $objDetailsId[0]['statusApprove'] = $value["statusApprove"];
                $objDetailsId[0]['historyId'] = $value["historyId"];
            }
        } else {
            $objDetailsId[0]['statusApprove'] = "";
            $objDetailsId[0]['historyId'] = "";
        }

        return $objDetailsId;
    }

}
