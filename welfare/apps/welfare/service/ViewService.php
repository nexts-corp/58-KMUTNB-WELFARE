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
        $daoWelfare= new Welfare();
        $daoWelfare->setWelfareId($id);
        $obj=$this->datacontext->getObject($daoWelfare);
        if (count($obj) > 0) {
            foreach ($obj as $key => $value) {
                $obj[$key]->dateStart = $value->dateStart->format('d-m-Y');
                $obj[$key]->dateEnd = $value->dateEnd->format('d-m-Y');
            }
        }
        $view->datas=$obj;
        return $view;
    }

    //end page welfare edit
    //start page welfare list

    public function welfareLists() {
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

    //end page welfare list
    //start page conditions add 

    public function conditionsAdd($id) {
        $view = new CJView("conditions/add", CJViewType::HTML_VIEW_ENGINE);
        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);
        
        $view->welfareId=$id;
        
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
                . "FROM ".$daoCondition."Conditions cdt Left JOIN ".$employeeType."Taxonomy  txn with "
                . "cdt.employeeTypeId = txn.id "
                . "where cdt.conditionsId = :id";
        
        $obj = $this->datacontext->getObject($sql,array("id"=>$id));
        
        $dateEndWork = $obj[0]['dateEndWork']->format('d-m-Y');
        $dateStartWork = $obj[0]['dateStartWork']->format('d-m-Y');
        $conditionsId=$obj[0]['conditionsId'];
        
        $view->dateEndWork=$dateEndWork;
        $view->dateStartWork=$dateStartWork;
        $view->conditionsId=$conditionsId;
        $sqlGender = "SELECT gd.genderId,"
                . "tn.id,tn.value1 "
                . "FROM ".$daoCondition."Conditions gd Left JOIN ".$employeeType."Taxonomy  tn with "
                . "gd.genderId = tn.id "
                . "where gd.conditionsId =$id";
        
        $objGender = $this->datacontext->getObject($sqlGender,array("id"=>$id));
        
        
        $view->datas=$obj;
        $view->welfareId=$id;
    if(empty($objGender[0]['genderId'])){
        $gender = new Taxonomy();
        $gender->pCode = "gender";
        $view->gender = $this->datacontext->getObject($gender);
        }else{
         $view->gender=$objGender;
        }
        return $view;
    }

    //end page conditions view edit
    //start page conditions view lists 

    public function conditionsLists($id) {
        $view = new CJView("conditions/lists", CJViewType::HTML_VIEW_ENGINE);
        
        $employeeType = '\\apps\\taxonomy\\entity\\';
        $daoCondition = '\\apps\\welfare\\entity\\';
        
        
        $sql = "SELECT cdt.conditionsId,cdt.welfareId,cdt.welfareId,cdt.description,"
                . "cdt.welfareId,cdt.amount,cdt.dateStartWork,cdt.dateEndWork,cdt.ageStart,"
                . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,"
                . "cdt.returnTypeId,txn.id,txn.value1 "
                . "FROM ".$daoCondition."Conditions cdt Left JOIN ".$employeeType."Taxonomy  txn with "
                . "cdt.employeeTypeId = txn.id "
                . "where cdt.welfareId = :id";
        
     $obj = $this->datacontext->getObject($sql,array("id"=>$id));

        
        $view->datas=$obj;
        $view->welfareId=$id;

        return $view;
    }

    //end page conditions view lists
}
