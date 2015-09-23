<?php

namespace apps\wfmember\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\wfmember\interfaces\IViewService;
use apps\wfmember\entity\Welfare;
use apps\wfmember\entity\Conditions;
use apps\taxonomy\entity\Taxonomy;
use apps\member\entity\Member;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    

    public function historyPreview($data) {

        $view = new CJView("history/lists", CJViewType::HTML_VIEW_ENGINE);

        $detailsId = $data->detailsId;
        $memberId = $data->memberId;
        $welfareId = $data->welfareId;

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];


        $path = '\\apps\\taxonomy\\entity\\';
        $parthWelfare = '\\apps\\welfare\\entity\\';

        $sqlWelfare = "SELECT dt.welfareId,dt.description , dt.quantity,"
                . "wf.welfareId , wf.name , wf.description, "
                . "wf.description As wfDescription, wf.dateStart, "
                . "wf.resetTime , wf.dateEnd , wf.free , "
                . "rt.id As returnType , rt.value1 As returnTypeValue  "
                . "FROM " . $parthWelfare . "Details dt "
                . "Left JOIN " . $parthWelfare . "Welfare wf "
                . "with dt.welfareId = wf.welfareId "
                . "Left JOIN " . $path . "Taxonomy  rt  "
                . "with dt.returnTypeId = rt.id "
                . "where dt.detailsId = :detailsId";
        $param = array(
            "detailsId" => $detailsId
        );
        $objWelfare = $this->datacontext->getObject($sqlWelfare, $param)[0];
        if($dateBudget["startDate"]){
        $year543 = explode("-", $dateBudget["startDate"]);
        $objWelfare["dateStart"] = $year543[2] . "-" . $year543[1] . "-" . intval($year543[0] + 543);
        }
        if($dateBudget["endDate"]){
        $year543 = explode("-", $dateBudget["endDate"]);
        $objWelfare["dateEnd"] = $year543[2] . "-" . $year543[1] . "-" . intval($year543[0] + 543);
        }

        if ($objWelfare['free'] == "Y" || $objWelfare['free'] == null) {
            $view->freeCheck = "สวัสดิการให้เปล่า";
        } else {
            $view->freeCheck = "สวัสดิการให้ยืม";
        }

        if ($objWelfare['resetTime'] == "0") {
            $view->resetTimeAll = "ให้ครั้งเดียว";
        } elseif ($objWelfare['resetTime'] == "6") {
            $view->resetTimeAll = "ให้ทุก 6 เดือน";
        } elseif ($objWelfare['resetTime'] == "12") {
            $view->resetTimeAll = "ให้ทุก 1 ปี";
        }

        $view->datasWelfare = $objWelfare;

        $sqlHistory = "SELECT htr.remark,htr.historyId,htr.detailsId,htr.welfareId , htr.amount ,"
                . "htr.dateCreated,htr.dateUse,htr.memberId "
                . "FROM " . $parthWelfare . "History htr "
                . "where htr.detailsId = :detailsId And htr.memberId = :memberId And htr.welfareId = :welfareId ";

        $param = array("detailsId" => $detailsId,
            "memberId" => $memberId,
            "welfareId" => $welfareId);

        if ($dateBudget["endDate"] != "") {
            $sqlHistory .= "and htr.dateCreated between :startDate and :endDate ";
            $param["startDate"] = $dateBudget["startDate"];
            $param["endDate"] = $dateBudget["endDate"];
        }

        $objHistory = $this->datacontext->getObject($sqlHistory, $param);
     
        $i = 1;
        foreach ($objHistory as $key1 => $value1) {
            
            foreach ($value1 as $key2 => $value2) {
                $objHistory[$key1]["rowNo"] = $i;
              
                if (is_a($value2, "DateTime")) {
                    $Y = $value2->format('Y') + 543;
                    $objHistory[$key1][$key2] = $objHistory[$key1][$key2]->format('d-m-'.$Y);
                    
                }
            }
            $i++;
        }
        
        $view->countRows = --$i;
        $view->welfareId = $welfareId;

        $view->memberId = $memberId;
        $view->detailsId = $detailsId;

        $view->datasHistory = $objHistory;

        $total = 0;
        foreach ($objHistory as $key => $value) {
            $total += $value['amount'];
        }
        $view->totalBudget = number_format($total);

        $view->total = number_format($objWelfare['quantity'] - $total);

        return $view;
    }

  


    public function byMemberLists() {
        $view = new CJView("byMember/lists", CJViewType::HTML_VIEW_ENGINE);
        
//          $memberId=$this->getCurrentUser()->memberId;
//        
//        $query = "SELECT *,IFNULL(academic1,titleName1) title "
//                . "FROM v_fullmember Where memberId='$memberId '";
//
//        $member = $this->datacontext->pdoQuery($query);
//        
//        $i = 1;
//
//        foreach ($member as $key => $value) {
//            $member[$key]["rowNo"] = $i++;
//        }


       // $view->datasMember = $member;

        return $view;
    }

    public function byMemberWfLists() {

        $view = new CJView("byMember/wfLists", CJViewType::HTML_VIEW_ENGINE);
        
        
        
        $memberId = $this->getCurrentUser()->code;
        
        
        $mb = new \apps\member\service\MemberService();
        $member = $mb->find("memberId", $memberId)[0];
        $employeeTypeId = $member->employeeTypeId;
      

        $parthWelfare = '\\apps\\welfare\\entity\\';

        $sqlDetails = "select detailsId
                              from welfareconditions where fieldMap = :fieldmap and valuex in 
                                   ( 
                                       select employeeTypeId from v_fullmember where memberId =:memberId
                                    )";

        $param = array("memberId" => $memberId, "fieldmap" => "employeeTypeId");
        $details = $this->datacontext->pdoQuery($sqlDetails, $param);
        $matchId = array();
        foreach ($details as $valueId) {
            $condition = new Conditions();
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
            //print_r($dataCheck);
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

        $sqlDetails = "SELECT wfdt.detailsId as detailsId,wfdt.quantity,wfdt.returnTypeId, "
                . "wfdt.welfareId,  "
                . "rt.value1 As returntType,rt.id,"
                . "wf.name,wf.statusActive,wf.description "
                . " FROM  welfaredetails wfdt "
                . "Left JOIN  welfare wf "
                . "on wfdt.welfareId = wf.welfareId "
                . "Left JOIN taxonomy rt  "
                . "on wfdt.returnTypeId = rt.id "
                . "where detailsId in ( " . $id . " )";


        $objDetailsId = $this->datacontext->pdoQuery($sqlDetails);

        $i = 1;
        foreach ($objDetailsId as $key => $value) {

            $objDetailsId[$key]["rowNo"] = $i++;
        }

        $view->memberId = $memberId;

        $view->datasConditions = $objDetailsId;
        return $view;
    }

    //end page conditions view lists
}
