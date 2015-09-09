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
                $obj[$key]->dateStart = $value->dateStart->format('d-m-Y');
                $obj[$key]->dateEnd = $value->dateEnd->format('d-m-Y');
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

    public function conditionsAdd($id) {
        $view = new CJView("conditions/add", CJViewType::HTML_VIEW_ENGINE);

        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);

        $unit = new Taxonomy();
        $unit->pCode = "unit";
        $view->unit = $this->datacontext->getObject($unit);

        $view->welfareId = $id;

        $gender = new Taxonomy();
        $gender->pCode = "gender";
        $view->gender = $this->datacontext->getObject($gender);

        return $view;
    }

    //end page conditions view add
    //start page conditions view edit 

    public function conditionsEdit($id) {
        $view = new CJView("conditions/edit", CJViewType::HTML_VIEW_ENGINE);

        $employeeType = '\\apps\\taxonomy\\entity\\';
        $daoCondition = '\\apps\\welfare\\entity\\';


        $sql = "SELECT cdt.conditionsId,cdt.description,"
                . "cdt.welfareId,cdt.amount,cdt.workStartDate,cdt.workEndDate,cdt.ageStart,cdt.ageEnd,"
                . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,"
                . "cdt.returnTypeId,txn.id,txn.value1 "
                . "FROM " . $daoCondition . "Conditions cdt Left JOIN " . $employeeType . "Taxonomy  txn with "
                . "cdt.employeeTypeId = txn.id "
                . "where cdt.conditionsId = :id";

        $obj = $this->datacontext->getObject($sql, array("id" => $id));
        if ($obj[0]['workEndDate'] != null) {
            $workEndDate = $obj[0]['workEndDate']->format('d-m-Y');
            $view->workEndDate = $workEndDate;
        }
        if ($obj[0]['workStartDate']) {
            $workStartDate = $obj[0]['workStartDate']->format('d-m-Y');
            $view->workStartDate = $workStartDate;
        }

        $unit = new Taxonomy();
        $unit->pCode = "unit";
        $view->unit = $this->datacontext->getObject($unit);

        $conditionsId = $obj[0]['conditionsId'];
        $view->conditionsId = $conditionsId;
        $sqlGender = "SELECT gd.genderId,"
                . "tn.id,tn.value1 "
                . "FROM " . $daoCondition . "Conditions gd Left JOIN " . $employeeType . "Taxonomy  tn with "
                . "gd.genderId = tn.id "
                . "where gd.conditionsId =$id";

        $objGender = $this->datacontext->getObject($sqlGender, array("id" => $id));


        $view->datas = $obj;
        $view->welfareId = $id;
        if (empty($objGender[0]['genderId'])) {
            $gender = new Taxonomy();
            $gender->pCode = "gender";
            $view->gender = $this->datacontext->getObject($gender);
        } else {
            $view->gender = $objGender;
        }
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

//    public function previewsTestLists($conditions) {
//        
//        $query = "SELECT mb.fname,mb.lname,mb.employeeTypeId,mb.titleId,mb.genderId,mb.dob,mb.workStartDate,mb.workEndDate , mb.facultyId , "
//                . "mb.departmentId,"
//                . "(title.value1) As title, "
//                . "(academic.value1) As academic, "
//                . "(employeeType.value1) As employeeType, "
//                . "(gender.value1) As gender, "
//                . "(faculty.value1) As faculty, "
//                . "(department.value1) As department "
//                . "FROM member mb "
//                . "Left JOIN taxonomy title "
//                . "on mb.titleId = title.id "
//                . "Left JOIN taxonomy academic "
//                . "on mb.academicId = academic.id "
//                . "Left JOIN taxonomy employeeType "
//                . "on mb.employeeTypeId = employeeType.id "
//                . "Left JOIN taxonomy gender "
//                . "on mb.genderId = gender.id "
//                . "Left JOIN taxonomy faculty "
//                . "on mb.facultyId = faculty.id "
//                . "Left JOIN taxonomy department "
//                . "on mb.departmentId = department.id "
//                . "where ";
//        $where = "";
//        $param = array();
//        foreach ($conditions as $key => $value) {
//            if ($key == 0) {
//                foreach ($value as $key2 => $value2) {
//                    if ($value2 != null) {
//                        if ($where != "") {
//                            $where .= " and ";
//                        }
//                        switch ($key2) {
//                            case "workStartDate":
//                                $where .= " mb.workStartDate >= :" . $key2 . " ";
//                                $param[$key2] = $value2->format('Y-m-d');
//                                break;
//                            case "workEndDate":
//                                $where .= " mb.workEndDate <= :" . $key2 . " ";
//                                $param[$key2] = $value2->format('Y-m-d');
//                                break;
//                            case "ageStart":
//                                $where .= " TIMESTAMPDIFF(YEAR, mb.dob, CURDATE()) >= :" . $key2 . " ";
//                                // . "CURRENT_DATE()-mb.dob >= :" . $key2 . " ";
//                                $param[$key2] = $value2;
//                                break;
//                            case "ageEnd":
//                                $where .= " TIMESTAMPDIFF(YEAR, mb.dob, CURDATE()) <= :" . $key2 . " ";
//                                $param[$key2] = $value2;
//                                break;
//                            case "ageWorkStart":
//                                $where .= " TIMESTAMPDIFF(YEAR, mb.workStartDate, CURDATE()) >= :" . $key2 . " ";
//                                $param[$key2] = $value2;
//                                break;
//                            case "ageWorkEnd":
//                                $where .= " TIMESTAMPDIFF(YEAR, mb.workStartDate, CURDATE()) <= :" . $key2 . " ";
//                                $param[$key2] = $value2;
//                                break;
//                            case "genderId":
//                                $where .= " mb.genderId = :" . $key2 . " ";
//                                $param[$key2] = $value2;
//                                break;
//                            case "employeeTypeId":
//                                $where .= " mb.employeeTypeId = :" . $key2 . " ";
//                                $param[$key2] = $value2;
//                                break;
//                        }
//                    }
//                }
//            } else {
//                if ($where != "") {
//                    $where .= " or ";
//                }
//                $where .= " mb.employeeTypeId = :employeeTypeId" . $key . " ";
//                $param["employeeTypeId" . $key] = $value->employeeTypeId;
//            }
//        }
//        $sql = $query . $where;
//        $member = $this->datacontext->pdoQuery($sql, $param);
//        return $member;
//      
//    }

    public function previewsUserLists($conditionsId) {

        $view = new CJView("previews/lists", CJViewType::HTML_VIEW_ENGINE);
        
        $condition = new Conditions();
        $condition->conditionsId = $conditionsId;
        $dataConditions = $this->datacontext->getObject($condition); //get condition
        
        $conServ = new ConditionsService();
        $data = $conServ->preview($dataConditions);
        $i=1;
        foreach($data as $key => $value){
            $data[$key]["rowNo"] = $i++;
        }
        $view->datas = $data;
        $view->maxRows=--$i;
        
        return $view;
    }

    //end page conditions view lists
}
