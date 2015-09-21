<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IViewService;
use apps\welfare\entity\Welfare;
use apps\welfare\entity\Conditions;
use apps\taxonomy\entity\Taxonomy;
use apps\member\entity\Member;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    // start page welfare add
    public function welfareAdd() {
        $view = new CJView("welfare/add", CJViewType::HTML_VIEW_ENGINE);

        $unit = new Taxonomy();
        $unit->pCode = "unit";
        $view->unit = $this->datacontext->getObject($unit);

        return $view;
    }

    // end page welfare add
    // start page welfare edit

    public function welfareEdit() {

        $welfarId = $this->getRequest()->welfareId;
        $view = new CJView("welfare/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare = new Welfare();
        $daoWelfare->setWelfareId($welfarId);
        $obj = $this->datacontext->getObject($daoWelfare);
        foreach ($obj as $key => $value) {

            $dsY = $value->dateStart->format('Y') + 543;
            $deY = $value->dateEnd->format('Y') + 543;

            $obj[$key]->dateStart = $value->dateStart->format('d-m-' . $dsY);
            $obj[$key]->dateEnd = $value->dateEnd->format('d-m-' . $deY);
        }

        $view->datas = $obj;
        return $view;
    }

    //end page welfare edit
    //start page welfare list

    public function welfareLists() {

        $data = $this->getRequest()->SearchName;

        if (!empty($data)) {
            $view = new CJView("welfare/lists", CJViewType::HTML_VIEW_ENGINE);
            $sql = "select wf from \\apps\\welfare\\entity\\welfare wf "
                    . " where wf.name LIKE :name ";
            $obj = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));

            if (count($obj) > 0) {
                foreach ($obj as $key => $value) {

                    $dsY = $value->dateStart->format('Y') + 543;
                    $deY = $value->dateEnd->format('Y') + 543;

                    $obj[$key]->dateStart = $value->dateStart->format('d-m-' . $dsY);
                    $obj[$key]->dateEnd = $value->dateEnd->format('d-m-' . $deY);
                }
            }
            $view->datas = $obj;
            return $view;
        } else {
            $view = new CJView("welfare/lists", CJViewType::HTML_VIEW_ENGINE);
            $daoWelfare = new Welfare();
            $obj = $this->datacontext->getObject($daoWelfare);

            if (count($obj) > 0) {
                foreach ($obj as $key => $value) {
                    if ($value->dateStart != "") {
                        $dsY = $value->dateStart->format('Y') + 543;
                        $obj[$key]->dateStart = $value->dateStart->format('d-m-' . $dsY);
                    }
                    if ($value->dateEnd != "") {
                        $deY = $value->dateEnd->format('Y') + 543;
                        $obj[$key]->dateEnd = $value->dateEnd->format('d-m-' . $deY);
                    }
                }
            }

            $view->datas = $obj;

            return $view;
        }
    }

    //end page welfare list
    //start page conditions add 

    public function conditionsAdd() {

        $welfareId = $this->getRequest()->welfareId;

        $view = new CJView("conditions/add", CJViewType::HTML_VIEW_ENGINE);

        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);

        $unit = new Taxonomy();
        $unit->pCode = "unit";
        $view->unit = $this->datacontext->getObject($unit);

        $view->welfareId = $welfareId;

        $gender = new Taxonomy();
        $gender->pCode = "gender";
        $view->gender = $this->datacontext->getObject($gender);

        return $view;
    }

    //end page conditions view add
    //start page conditions view edit 

    public function conditionsEdit() {

        $conditionsId = $this->getRequest()->conditionsId;

        $view = new CJView("conditions/edit", CJViewType::HTML_VIEW_ENGINE);

        $path = '\\apps\\taxonomy\\entity\\';
        $daoCondition = '\\apps\\welfare\\entity\\';

        $sql = "SELECT cdt.conditionsId,cdt.description,"
                . "cdt.welfareId,cdt.quantity,cdt.workStartDate,cdt.workEndDate,cdt.ageStart,cdt.ageEnd,"
                . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId, cdt.returnTypeId, cdt.genderId , "
                . "ept.id As employeeTypeId , ept.value1 As employeeTypeValue , "
                . "gd.id As genderId , gd.value1 As genderValue "
                . "FROM " . $daoCondition . "Conditions cdt "
                . "Left JOIN " . $path . "Taxonomy  ept "
                . "with cdt.employeeTypeId = ept.id "
                . "Left JOIN " . $path . "Taxonomy  gd  "
                . "with cdt.genderId = gd.id "
                . "where cdt.conditionsId = :conditionsId";

        $obj = $this->datacontext->getObject($sql, array("conditionsId" => $conditionsId));


        if ($obj[0]['workEndDate'] != null) {

            $workEndDate = explode("-", $obj[0]['workEndDate']);
            $workEndDate[2] = intVal($workEndDate[2]) + 543;
            $workEndDate1 = $workEndDate[2] . "-" . $workEndDate[1] . "-" . $workEndDate[0];

            //$workEndDate = $obj[0]['workEndDate']->format('d-m-Y');
            $view->workEndDate = $workEndDate1;
        }
        if ($obj[0]['workStartDate']) {
            $workStartDate = $obj[0]['workStartDate']->format('d-m-Y');
            $view->workStartDate = $workStartDate;
        }

        $unit = new Taxonomy();
        $unit->pCode = "unit";
        $view->unit = $this->datacontext->getObject($unit);

        $view->conditionsId = $conditionsId;
        $view->welfareId = $obj[0]["welfareId"];
        $view->datas = $obj;


        //$view->gender = $objGender;
        return $view;
    }

    //end page conditions view edit
    //start page conditions view lists 

    public function conditionsLists() {

        $view = new CJView("conditions/lists", CJViewType::HTML_VIEW_ENGINE);
        $SearchName = $this->getRequest()->SearchName;
        $welfareId = $this->getRequest()->welfareId;
        $view->welfareId = $welfareId;

        $employeeType = '\\apps\\taxonomy\\entity\\';
        $daoCondition = '\\apps\\welfare\\entity\\';
        if (!empty($SearchName)) {
            $sql = "SELECT cdt.conditionsId,cdt.welfareId,cdt.description,"
                    . "cdt.quantity,cdt.workStartDate,cdt.workEndDate,cdt.ageStart,"
                    . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,"
                    . "cdt.returnTypeId,txn.id,txn.value1 "
                    . "FROM " . $daoCondition . "Conditions cdt Left JOIN " . $employeeType . "Taxonomy  txn with "
                    . "cdt.employeeTypeId = txn.id "
                    . " where cdt.description LIKE :name or txn.value1 LIKE :name or cdt.quantity LIKE :name";
            $obj = $this->datacontext->getObject($sql, array("name" => "%" . $SearchName . "%"));
        } elseif (isset($welfareId)) {
            $sql = "SELECT cdt.conditionsId,cdt.description, "
                    . "cdt.welfareId,cdt.quantity,cdt.workStartDate,cdt.workEndDate,cdt.ageStart, "
                    . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,cdt.returnTypeId, "
                    . "emp.id as employeeTypeId,emp.value1 as employeeType "
                    . "FROM " . $daoCondition . "Conditions cdt "
                    . "Left JOIN " . $employeeType . "Taxonomy  emp  "
                    . "with cdt.employeeTypeId = emp.id "
                    . "where cdt.welfareId = :welfareId";
            $obj = $this->datacontext->getObject($sql, array("welfareId" => $welfareId));
        }
        $view->datas = $obj;

        return $view;
    }

    public function previewsUserLists($data) {

        $view = new CJView("previews/lists", CJViewType::HTML_VIEW_ENGINE);

        $conditionsId = $data->conditionsId;
        $welfareId = $data->welfareId;

        $view->welfareId = $welfareId;

        $condition = new Conditions();
        $condition->conditionsId = $conditionsId;

        $dataConditions = $this->datacontext->getObject($condition); //get condition

        $conServ = new ConditionsService();
        $data = $conServ->preview($dataConditions);

        if ($data > 0) {
            $i = 1;
            foreach ($data as $key => $value) {
                $data[$key]["rowNo"] = $i++;
            }

            $view->datas = $data;
            $view->maxRows = --$i;
        }
        $view->conditionsId = $conditionsId;

        return $view;
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

    public function historyAdd($data) {
        $view = new CJView("history/add", CJViewType::HTML_VIEW_ENGINE);

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

        $sqlWelfare = "SELECT cdt.quantity,cdt.welfareId, cdt.description ,"
                . "wf.welfareId , wf.name , "
                . "wf.description As wfDescription, wf.dateStart, "
                . "wf.resetTime , wf.dateEnd , wf.free , "
                . "un.id As unitId , un.value1 As unitValue  "
                . "FROM " . $parthWelfare . "Details cdt "
                . "Left JOIN " . $parthWelfare . "Welfare wf "
                . "with cdt.welfareId = wf.welfareId "
                . "Left JOIN " . $path . "Taxonomy  un  "
                . "with cdt.returnTypeId = un.id "
                . "where cdt.detailsId = :detailsId";
        $param = array(
            "detailsId" => $detailsId
        );
        $objWelfare = $this->datacontext->getObject($sqlWelfare, $param)[0];

        $year543 = explode("-", $dateBudget["startDate"]);
        $objWelfare["dateStart"] = $year543[2] . "-" . $year543[1] . "-" . intval($year543[0] + 543);
        $year543 = explode("-", $dateBudget["endDate"]);
        $objWelfare["dateEnd"] = $year543[2] . "-" . $year543[1] . "-" . intval($year543[0] + 543);

        if ($objWelfare['free'] == "Y" || $objWelfare['free'] == null) {
            $view->freeCheck = "สวัสดิการให้เปล่า";
        } else {
            $view->freeCheck = "สวัสดิการให้ยืม";
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
        //print_r($objHistory);
        $i = 1;
        foreach ($objHistory as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                $objHistory[$key1]["rowNo"] = $i;
                if (is_a($value2, "DateTime")) {
                    $Y = $value2->format('Y') + 543;
                    $objHistory[$key1][$key2] = $objHistory[$key1][$key2]->format('d-m-' . $Y);
//                    $objHistory[$key] = $i++;
                }
            }
            $i++;
        }
        $view->countRows = --$i;


        $view->datasHistory = $objHistory;

        $total = 0;
        foreach ($objHistory as $key => $value) {
            $total += $value['amount'];
        }
        
        $view->totalBudget = number_format($total);
        $view->total = number_format($objWelfare['quantity'] - $total);
        $view->totalWf = $objWelfare['quantity'] - $total;

        $view->memberId = $memberId;
        $view->detailsId = $detailsId;
        $view->welfareId = $welfareId;
        return $view;
    }

    public function historyEdit() {

        $view = new CJView("history/edit", CJViewType::HTML_VIEW_ENGINE);

        $historyId = $this->getRequest()->historyId;

        $parthWelfare = '\\apps\\welfare\\entity\\';

        $sqlHistory = "SELECT htr.remark,htr.detailsId,htr.welfareId , htr.amount ,"
                . "htr.dateCreated,htr.dateUse,htr.memberId "
                . "FROM " . $parthWelfare . "History htr "
                . "where htr.historyId = :historyId ";

        $objHistory = $this->datacontext->getObject($sqlHistory, array("historyId" => $historyId));

        $view->historyId = $historyId;

        $view->memberId = $objHistory[0]["memberId"];
        $view->detailsId = $objHistory[0]["detailsId"];
        $view->welfareId = $objHistory[0]["welfareId"];

        $view->datasHistory = $objHistory;
        return $view;
    }

    public function byMemberLists() {
        $view = new CJView("byMember/lists", CJViewType::HTML_VIEW_ENGINE);

        $query = "SELECT *,IFNULL(academic1,titleName1) title "
                . "FROM v_fullmember  ";

        $member = $this->datacontext->pdoQuery($query);

        $i = 1;

        foreach ($member as $key => $value) {
            $member[$key]["rowNo"] = $i++;
        }


        $view->datasMember = $member;

        return $view;
    }

    public function byMemberWfLists($data) {

        $view = new CJView("byMember/wfLists", CJViewType::HTML_VIEW_ENGINE);



        $memberId = $data->memberId;
        $mb = new \apps\member\service\MemberService();
        $member = $mb->find("memberId", $memberId)[0];
        $employeeTypeId = $data->fieldMap;

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
