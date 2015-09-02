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


        $sql = "SELECT cdt.conditionsId,cdt.welfareId,cdt.welfareId,cdt.description,"
                . "cdt.welfareId,cdt.amount,cdt.dateStartWork,cdt.dateEndWork,cdt.ageStart,cdt.ageEnd,"
                . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,"
                . "cdt.returnTypeId,txn.id,txn.value1 "
                . "FROM " . $daoCondition . "Conditions cdt Left JOIN " . $employeeType . "Taxonomy  txn with "
                . "cdt.employeeTypeId = txn.id "
                . "where cdt.conditionsId = :id";

        $obj = $this->datacontext->getObject($sql, array("id" => $id));
        if ($obj[0]['dateEndWork'] != null) {
            $dateEndWork = $obj[0]['dateEndWork']->format('d-m-Y');
            $view->dateEndWork = $dateEndWork;
        }
        if ($obj[0]['dateStartWork']) {
            $dateStartWork = $obj[0]['dateStartWork']->format('d-m-Y');
            $view->dateStartWork = $dateStartWork;
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

    public function conditionsLists($id) {


        $data = $this->getRequest()->SearchName;

        if (!empty($data)) {
            $view = new CJView("conditions/lists", CJViewType::HTML_VIEW_ENGINE);
            $employeeType = '\\apps\\taxonomy\\entity\\';
            $daoCondition = '\\apps\\welfare\\entity\\';

            $sql = "SELECT cdt.conditionsId,cdt.welfareId,cdt.welfareId,cdt.description,"
                    . "cdt.welfareId,cdt.amount,cdt.dateStartWork,cdt.dateEndWork,cdt.ageStart,"
                    . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,"
                    . "cdt.returnTypeId,txn.id,txn.value1 "
                    . "FROM " . $daoCondition . "Conditions cdt Left JOIN " . $employeeType . "Taxonomy  txn with "
                    . "cdt.employeeTypeId = txn.id "
                    . " where cdt.description LIKE :name or txn.value1 LIKE :name or cdt.amount LIKE :name";
            $obj = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));

            $view->datas = $obj;
            $view->welfareId = $id;

            return $view;
        } else {
            $view = new CJView("conditions/lists", CJViewType::HTML_VIEW_ENGINE);

            $employeeType = '\\apps\\taxonomy\\entity\\';
            $daoCondition = '\\apps\\welfare\\entity\\';


            $sql = "SELECT cdt.conditionsId,cdt.welfareId,cdt.welfareId,cdt.description, "
                    . "cdt.welfareId,cdt.amount,cdt.dateStartWork,cdt.dateEndWork,cdt.ageStart, "
                    . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,cdt.returnTypeId, "
                    . "emp.id as employeeTypeId,emp.value1 as employeeType "
                    . "FROM " . $daoCondition . "Conditions cdt "
                    . "Left JOIN " . $employeeType . "Taxonomy  emp  "
                    . "with cdt.employeeTypeId = emp.id "
                    . "where cdt.welfareId = :id";

            $obj = $this->datacontext->getObject($sql, array("id" => $id));


            $view->datas = $obj;
            $view->welfareId = $id;

            return $view;
        }
    }

    public function previewsLists($id) {

        $view = new CJView("previews/lists", CJViewType::HTML_VIEW_ENGINE);
//        $daoWelfare = new Welfare();
//        $daoWelfare->setWelfareId($id);
//        $obj = $this->datacontext->getObject($daoWelfare);
//        $free=$obj[0]->free;
//        
//        $partConditions = '\\apps\\welfare\\entity\\';
//        $partMember = '\\apps\\member\\entity\\';
//        $partTaxonomy = '\\apps\\taxonomy\\entity\\';
//        if($free=="yes"){
//           
//            $sql="SELECT cdt.employeeTypeId,cdt.ageStart,cdt.ageEnd,cdt.ageWorkStart,cdt.ageWorkEnd,cdt.ageWorkEnd,cdt.genderId,"
//            . "mb.fname,mb.lname,mb.workStartDate,mb.employeeTypeId,mb.facultyId,mb.departmentId,mb.dob"
//            . "FROM ".$partConditions."Conditions cdt Left JOIN ".$partMember."Member mb Left JOIN ".$partTaxonomy." txn with"
//            . "where cdt.welfareId = :id";
//          $this->datacontext->getObject($sql,array("id"=>$id));
//        
//            
//        
//        }

        return $view;
    }

    public function previewsTestLists($conditions) {
        
        
        $conditions[0]->dateStartWork;
        $conditions[0]->dateEndWork;
        $conditions[0]->ageStart;
        $conditions[0]->ageEnd;
        $conditions[0]->ageWorkStart;
        $conditions[0]->ageWorkEnd;
        $conditions[0]->genderId;
        //$conditions[0]->employeeTypeId;
       
        
        if($conditions[0]->dateStartWork !=""){
          $checkDateStartWork=" and cdt.dateStartWork = mb.workStartDate ";
        }
        if($conditions[0]->dateEndWork !=""){
            $checkdateEndWork=" and cdt.dateEndWork = mb.workEndDate ";
        }
        if($conditions[0]->ageStart !=""){
            
           //อายุตั้งแต่ 30 
            $checkageStart=" and cdt.ageStart = mb.dob ";
        }
        if($conditions[0]->ageEnd !=""){
            //ถึง 50
            $checkageEnd=" and cdt.ageEnd = mb.workEndDate ";
        }
         if($conditions[0]->ageWorkStart !=""){
            $checkageWorkStart=" and cdt.dateEndWork = mb.workEndDate ";
        }
         if($conditions[0]->ageWorkEnd !=""){
            $checkageWorkEnd=" and cdt.dateEndWork = mb.workEndDate ";

        }
        if($conditions[0]->genderId !=""){
            $checkgenderId="".$conditions[0]->genderId." = mb.genderId ";
        }

        //$partConditions = '\\apps\\welfare\\entity\\';
        $partMember = '\\apps\\member\\entity\\';
        $partTaxonomy = '\\apps\\taxonomy\\entity\\';
        

        $sql = "SELECT mb.fname,mb.lname,mb.workStartDate,mb.employeeTypeId, "
                . "mb.facultyId,mb.departmentId,mb.dob "
                . "FROM " . $partMember . "Member mb "
                . "Left JOIN " . $partTaxonomy . "Taxonomy txn"
                . "where  $checkgenderId";
        
        $obj=$this->datacontext->getObject($sql);
        
        print_r($obj);
        
        return $conditions;
    }

    //end page conditions view lists
}
