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
                $Y = Date('Y') + 543;
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
        
        $conditionsId=$this->getRequest()->conditionsId;
        
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

        return $view;
    }

    //end page conditions view lists
}
