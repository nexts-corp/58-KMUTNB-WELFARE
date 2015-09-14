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
        return $view;
    }

    // end page welfare add
    // start page welfare edit

    public function welfareEdit($id) {
        $view = new CJView("welfare/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare = new Welfare();
        $daoWelfare->setWelfareId($id);
        $obj = $this->datacontext->getObject($daoWelfare);
        if (count($obj) > 0) {
            foreach ($obj as $key => $value) {
                $Y = $value->format('Y') + 543;
                $obj[$key]->dateStart = $value->dateStart->format('d-m-' . $Y . '');
                $obj[$key]->dateEnd = $value->dateEnd->format('d-m-' . $Y . '');
            }
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
                    $obj[$key]->dateStart = $value->dateStart->format('d-m-Y');
                    $obj[$key]->dateEnd = $value->dateEnd->format('d-m-Y');
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
                    $obj[$key]->dateStart = $value->dateStart->format('d-m-Y');
                    $obj[$key]->dateEnd = $value->dateEnd->format('d-m-Y');
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
                . "cdt.welfareId,cdt.amount,cdt.workStartDate,cdt.workEndDate,cdt.ageStart,cdt.ageEnd,"
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

        $view->datas = $obj;


        //$view->gender = $objGender;
        return $view;
    }

    //end page conditions view edit
    //start page conditions view lists 

    public function conditionsLists() {
        $SearchName = $this->getRequest()->SearchName;
        $welfareId = $this->getRequest()->welfareId;
        $view = new CJView("conditions/lists", CJViewType::HTML_VIEW_ENGINE);
        $employeeType = '\\apps\\taxonomy\\entity\\';
        $daoCondition = '\\apps\\welfare\\entity\\';
        if (!empty($SearchName)) {
            $sql = "SELECT cdt.conditionsId,cdt.welfareId,cdt.description,"
                    . "cdt.amount,cdt.workStartDate,cdt.workEndDate,cdt.ageStart,"
                    . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,"
                    . "cdt.returnTypeId,txn.id,txn.value1 "
                    . "FROM " . $daoCondition . "Conditions cdt Left JOIN " . $employeeType . "Taxonomy  txn with "
                    . "cdt.employeeTypeId = txn.id "
                    . " where cdt.description LIKE :name or txn.value1 LIKE :name or cdt.amount LIKE :name";
            $obj = $this->datacontext->getObject($sql, array("name" => "%" . $SearchName . "%"));
        } elseif (isset($welfareId)) {
            $sql = "SELECT cdt.conditionsId,cdt.description, "
                    . "cdt.welfareId,cdt.amount,cdt.workStartDate,cdt.workEndDate,cdt.ageStart, "
                    . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,cdt.returnTypeId, "
                    . "emp.id as employeeTypeId,emp.value1 as employeeType "
                    . "FROM " . $daoCondition . "Conditions cdt "
                    . "Left JOIN " . $employeeType . "Taxonomy  emp  "
                    . "with cdt.employeeTypeId = emp.id "
                    . "where cdt.welfareId = :welfareId";
            $obj = $this->datacontext->getObject($sql, array("welfareId" => $welfareId));
        }
        $view->datas = $obj;
        $view->welfareId = $welfareId;
        return $view;
    }

    public function previewsUserLists() {

        $view = new CJView("previews/lists", CJViewType::HTML_VIEW_ENGINE);

        $conditionsId = $this->getRequest()->conditionsId;

        $condition = new Conditions();
        $condition->conditionsId = $conditionsId;

        $dataConditions = $this->datacontext->getObject($condition); //get condition

        $conServ = new ConditionsService();
        $data = $conServ->preview($dataConditions);
        $i = 1;

        foreach ($data as $key => $value) {
            $data[$key]["rowNo"] = $i++;
        }
        $view->datas = $data;
        $view->maxRows = --$i;
        $view->conditionsId = $conditionsId;


        return $view;
    }

    public function historyPreview($data) {

        $view = new CJView("history/lists", CJViewType::HTML_VIEW_ENGINE);

        $conditionsId = $data->conditionsId;
        $memberId = $data->memberId;


        $path = '\\apps\\taxonomy\\entity\\';
        $parthWelfare = '\\apps\\welfare\\entity\\';

        $sqlWelfare = "SELECT cdt.amount,cdt.conditionsId,cdt.welfareId, cdt.description ,"
                . "wf.welfareId , wf.name , "
                . "wf.description As wfDescription, wf.dateStart, "
                . "wf.resetTime , wf.dateEnd , wf.free , "
                . "un.id As unitId , un.value1 As unitValue  "
                . "FROM " . $parthWelfare . "Conditions cdt "
                . "Left JOIN " . $parthWelfare . "Welfare wf "
                . "with cdt.welfareId = wf.welfareId "
                . "Left JOIN " . $path . "Taxonomy  un  "
                . "with cdt.returnTypeId = un.id "
                . "where cdt.conditionsId = :conditionsId";

        $objWelfare = $this->datacontext->getObject($sqlWelfare, array("conditionsId" => $conditionsId))[0];

        foreach ($objWelfare as $key => $value) {
            if (is_a($value, "DateTime")) {
                $Y = $value->format('Y') + 543;
                $objWelfare[$key] = $value->format('d-m-' . $Y . '');
            }
        }
        if ($objWelfare['free'] == "Y" || $objWelfare['free'] == null) {
            $view->freeCheck = "สวัสดิการให้เปล่า";
        } else {
            $view->freeCheck = "สวัสดิการให้ยืม";
        }

        $view->datasWelfare = $objWelfare;

        $sqlHistory = "SELECT htr.historyId,htr.conditionsId,htr.welfareId , htr.amount ,"
                . "htr.dateCreated,htr.dateUse,htr.memberId "
                . "FROM " . $parthWelfare . "History htr "
                . "where htr.conditionsId = :conditionsId And htr.memberId = :memberId";

        $objHistory = $this->datacontext->getObject($sqlHistory, array("conditionsId" => $conditionsId, "memberId" => $memberId));
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

        $view->memberId = $memberId;
        $view->conditionsId = $conditionsId;
        $view->datasHistory = $objHistory;

        


        return $view;
    }

    public function historyAdd($data) {
        $view = new CJView("history/add", CJViewType::HTML_VIEW_ENGINE);

        $conditionsId = $data->conditionsId;
        $memberId = $data->memberId;
        $welfareId = $data->welfareId;
        
        $conditionsId = $data->conditionsId;
        $memberId = $data->memberId;


        $path = '\\apps\\taxonomy\\entity\\';
        $parthWelfare = '\\apps\\welfare\\entity\\';

        $sqlWelfare = "SELECT cdt.amount,cdt.conditionsId,cdt.welfareId, cdt.description ,"
                . "wf.welfareId , wf.name , "
                . "wf.description As wfDescription, wf.dateStart, "
                . "wf.resetTime , wf.dateEnd , wf.free , "
                . "un.id As unitId , un.value1 As unitValue  "
                . "FROM " . $parthWelfare . "Conditions cdt "
                . "Left JOIN " . $parthWelfare . "Welfare wf "
                . "with cdt.welfareId = wf.welfareId "
                . "Left JOIN " . $path . "Taxonomy  un  "
                . "with cdt.returnTypeId = un.id "
                . "where cdt.conditionsId = :conditionsId";

        $objWelfare = $this->datacontext->getObject($sqlWelfare, array("conditionsId" => $conditionsId))[0];

        foreach ($objWelfare as $key => $value) {
            if (is_a($value, "DateTime")) {
                $Y = $value->format('Y') + 543;
                $objWelfare[$key] = $value->format('d-m-' . $Y . '');
            }
        }
        if ($objWelfare['free'] == "Y" || $objWelfare['free'] == null) {
            $view->freeCheck = "สวัสดิการให้เปล่า";
        } else {
            $view->freeCheck = "สวัสดิการให้ยืม";
        }

        $view->datasWelfare = $objWelfare;
        
        $sqlHistory = "SELECT htr.historyId,htr.conditionsId,htr.welfareId , sum(htr.amount) ,"
                . "htr.memberId"
                . "FROM " . $parthWelfare . "History htr "
                . "where htr.conditionsId = :conditionsId And htr.memberId = :memberId";

        $objHistory = $this->datacontext->getObject($sqlHistory, array("conditionsId" => $conditionsId, "memberId" => $memberId));
        
        
      
        $view->memberId = $memberId;
        $view->conditionsId = $conditionsId;
        $view->welfareId = $welfareId;
        return $view;
    }
    
    public function historyEdit() {
        
        $view = new CJView("history/edit", CJViewType::HTML_VIEW_ENGINE);
        
        $historyId = $this->getRequest()->historyId;

        $parthWelfare = '\\apps\\welfare\\entity\\';

         $sqlHistory = "SELECT htr.conditionsId,htr.welfareId , htr.amount ,"
                . "htr.dateCreated,htr.dateUse,htr.memberId "
                . "FROM " . $parthWelfare . "History htr "
                . "where htr.historyId = :historyId ";

        $objHistory = $this->datacontext->getObject($sqlHistory, array("historyId" => $historyId));
        
        
        
        $view->historyId=$historyId;
        
        $view->datasHistory=$objHistory;
        return $view;
    }
    
    public function byMemberLists() {
        $view = new CJView("byMember/lists",  CJViewType::HTML_VIEW_ENGINE);
        
        $query =  "SELECT mb.memberId,mb.fname,mb.lname,mb.employeeTypeId,mb.titleId,mb.genderId,mb.dob,mb.workStartDate,mb.workEndDate , mb.facultyId , "
                . "mb.departmentId,"
//                . "(title.value1) As title, "
//                . "(academic.value1) As academic,"
                . "IFNULL(academic.value1,title.value1) title, " //IFNULL(value1,value2) select ถ้ามีค่าใดค่าหนึ่ง ,ถ้ามีค่าทั้งคู่จะ select value1 ออกมา 
                . "(employeeType.value1) As employeeType, "
                . "(gender.value1) As gender, "
                . "(faculty.value1) As faculty, "
                . "(department.value1) As department "
                . "FROM member mb "
                . "Left JOIN taxonomy title "
                . "on mb.titleId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mb.academicId = academic.id "
                . "Left JOIN taxonomy employeeType "
                . "on mb.employeeTypeId = employeeType.id "
                . "Left JOIN taxonomy gender "
                . "on mb.genderId = gender.id "
                . "Left JOIN taxonomy faculty "
                . "on mb.facultyId = faculty.id "
                . "Left JOIN taxonomy department "
                . "on mb.departmentId = department.id ";
        
        $member = $this->datacontext->pdoQuery($query);
      
        $i = 1;

        foreach ($member as $key => $value) {
            $member[$key]["rowNo"] = $i++;
        }
        
      
        
        $view->datasMember=$member;
        
        return $view;
    }
    
    
    //end page conditions view lists
}
