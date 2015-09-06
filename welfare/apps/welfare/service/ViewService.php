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

            $sql = "SELECT cdt.conditionsId,cdt.welfareId,cdt.description,"
                    . "cdt.amount,cdt.dateStartWork,cdt.dateEndWork,cdt.ageStart,"
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


            $sql = "SELECT cdt.conditionsId,cdt.description, "
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

    public function previewsTestLists($conditions) {

         if($conditions->conditionsId==""){
         $dateStartWork = $conditions[0]->dateStartWork;
         $dateEndWork = $conditions[0]->dateEndWork;
         $ageStart = $conditions[0]->ageStart;
         $ageEnd = $conditions[0]->ageEnd;
         $ageWorkStart = $conditions[0]->ageWorkStart;
         $ageWorkEnd = $conditions[0]->ageWorkEnd;
         $genderId = $conditions[0]->genderId;
         $employeeTypeId = $conditions[0]->employeeTypeId;
         }else{
         $conditionsId = $conditions->conditionsId;
         $dateStartWork = $conditions->dateStartWork;
         $dateEndWork = $conditions->dateEndWork;
         $ageStart = $conditions->ageStart;
         $ageEnd = $conditions->ageEnd;
         $ageWorkStart = $conditions->ageWorkStart;
         $ageWorkEnd = $conditions->ageWorkEnd;
         $genderId = $conditions->genderId;
         $employeeTypeId = $conditions->employeeTypeId;
         
         }
       

          //ตรวจสอบค่าว่าง วัน-เดือน-ปี ที่บรรจุงาน
          if ($dateStartWork != "" and $dateEndWork == "") {


          //ตรวจสอบค่า and
          if ($ageStart != "" || $ageEnd != "" || $ageWorkStart !="" || $ageWorkEnd != "" || $genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }

          //เงื่อนไข มากกว่า วัน-เดือน-ปี ที่บรรจุงาน
          $checkDateWork = " DATE_FORMAT(mb.workStartDate,'%Y-%m-%d') >= '$dateStartWork' " . $checkAnd . "";
          }

          //ตรวจสอบค่าว่าง วัน-เดือน-ปี วันที่เกษียณ
          if ($dateStartWork == "" and $dateEndWork != "") {

         

          //ตรวจสอบค่า and
          if ($ageStart != "" || $ageEnd != "" || $ageWorkStart !="" || $ageWorkEnd != "" || $genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }

          //เงื่อนไข น้อยกว่า วัน-เดือน-ปี ที่เกษียณ
          $checkDateWork = " DATE_FORMAT(mb.workEndDate,'%Y-%m-%d') <= '$dateEndWork' " . $checkAnd . " ";
          }

          // ตรวสอบค่าว่าง วัน-เดือน-ปี ที่บรรจุงาน และ วัน-เดือน-ปี ที่เกษียณ
          if ($dateStartWork != "" and $dateEndWork != "") {

          

          //ตรวจสอบค่า and
          if ($ageStart != "" || $ageEnd != "" || $ageWorkStart !="" || $ageWorkEnd != "" || $genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }

          //เงื่อนไข หาค่าที่ น้อยกว่า วัน-เดือน-ปี ที่เกษียณ และ มากกว่า วัน-เดือน-ปี ที่บรรจุงาน
          $checkDateWork = " DATE_FORMAT(mb.workEndDate,'%Y')  <= '$dateEndWork' AND DATE_FORMAT(mb.workStartDate,'%Y') >= '$dateStartWork' " . $checkAnd . " ";
          } elseif ($dateStartWork == "" and $dateEndWork == "") {

          //เช็คค่าว่าง ของเงื่อนไข
          $checkDateWork = "";
          }
          // เช็คค่าว่าง อายุสมาชิก ตั้งแต่
          if ($ageStart != "" and $ageEnd == "") {


          //ตรวจสอบค่า and
          if ($ageWorkStart !="" || $ageWorkEnd != "" || $genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }

          //เช็คเงื่อนไข  มากกว่าหรือเท่ากับ อายุของสมาชิก
          $checkAge = "  (YEAR( CURDATE( ) ) - YEAR(mb.dob )) >= '$ageStart' " . $checkAnd . " ";
          }
          // เช็คค่าว่าง อายุสมาชิก  ถึง
          if ($ageStart == "" and $ageEnd != "") {


          //ตรวจสอบค่า and
          if ($ageWorkStart !="" || $ageWorkEnd != "" || $genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }

          //เช็คเงื่อนไข  น้อยกว่าหรือเท่ากับ อายุของสมาชิก
          $checkAge = " (YEAR( CURDATE( ) ) - YEAR(mb.dob )) <= '$ageEnd' " . $checkAnd . " ";
          }

          // เช็คค่าว่าง อายุสมาชิก  ตั้งแต่-ถึง
          if ($ageEnd != "" and $ageStart != "") {

 
          //ตรวจสอบค่า and
          if ($ageWorkStart !="" || $ageWorkEnd != "" || $genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }

          //เงื่อนไข หาค่าระหว่าง อายุสมาชิกตั้งแต่...ปี ถึง ...ปี
          $checkAge = " (YEAR( CURDATE( ) ) - YEAR(mb.dob )) BETWEEN  '$ageStart' AND '$ageEnd' " . $checkAnd . " ";
          } elseif ($ageEnd == "" and $ageStart == "") {

          //เงื่อนไข ถ้าไม่มีการเช็คเงื่อนไข
          $checkAge = "";
          }

          // ตรวจสอบอายุการปฏิบัติงาน
          if ($ageWorkStart != "" and $ageWorkEnd == "") {


          //ตรวจสอบค่า and
          if ($genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }
          //เช็คอายุการปฏิบัติงาน ตั้งแต่
          $checkAgeWork = " (YEAR( CURDATE( ) ) - YEAR(mb.workStartDate )) >= '$ageWorkStart' " . $checkAnd . "";
          }

          if ($ageWorkStart == "" and $ageWorkEnd != "") {



          //ตรวจสอบค่า and
          if ($genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }
          //เช็คอายุการปฏิบัติงาน ถึง
          $checkAgeWork = " (YEAR( CURDATE( ) ) - YEAR(mb.workStartDate )) <= '$ageWorkEnd' " . $checkAnd . " ";
          }
          if ($ageWorkStart != "" and $ageWorkEnd != "") {

          //ตรวจสอบค่า and
          if ($genderId != "") {
          $checkAnd = "and";
          } else {
          $checkAnd = "";
          }
          //หาค่าระหว่าง อายุการปฏิบัติงาน ตั้งแต่...ปี ถึง...ปี
          $checkAgeWork = " (YEAR( CURDATE( ) ) - YEAR(mb.workStartDate)) BETWEEN  '$ageWorkStart' AND '$ageWorkEnd' " . $checkAnd . " ";
          } elseif ($ageWorkStart == "" and $ageWorkEnd == "") {
          $checkAgeWork = "";
          }

          //ตรวจสอบ เพศ
          if ($genderId != "") {

          $checkgenderId = "mb.genderId = " . $genderId . "";
          } elseif ($genderId == "") {
          $checkgenderId = "";
          }


          if($conditions->conditionsId ==""){

          $sql = "SELECT mb.fname,mb.lname,mb.employeeTypeId,mb.titleId,mb.genderId,mb.dob,mb.workStartDate,mb.workEndDate , mb.facultyId , "
          . "mb.departmentId,"
          . "(tax1.value1) As titlename, "
          . "(tax2.value1) As academic, "
          . "(tax3.value1) As employeeType, "
          . "(tax4.value1) As gender, "
          . "(tax5.value1) As faculty, "
          . "(tax6.value1) As department "
          . "FROM member mb "
          . "Left JOIN taxonomy tax1 "
          . "on mb.titleId = tax1.id "
          . "Left JOIN taxonomy tax2 "
          . "on mb.academicId = tax2.id "
          . "Left JOIN taxonomy tax3 "
          . "on mb.employeeTypeId = tax3.id "
          . "Left JOIN taxonomy tax4 "
          . "on mb.genderId = tax4.id "
          . "Left JOIN taxonomy tax5 "
          . "on mb.facultyId = tax5.id "
          . "Left JOIN taxonomy tax6 "
          . "on mb.departmentId = tax6.id "
          . "where " . $checkDateWork . " " . $checkAge . " " . $checkAgeWork . " " . $checkgenderId . "";

          $obj = $this->datacontext->pdoQuery($sql);
          return $obj;

          }
          
          if($conditions->conditionsId !=""){

          $sql = "SELECT mb.fname,mb.lname,mb.employeeTypeId,mb.titleId,mb.genderId,mb.dob,mb.workStartDate,mb.workEndDate , mb.facultyId , "
          . "mb.departmentId,"
          . "(tax1.value1) As titlename, "
          . "(tax2.value1) As academic, "
          . "(tax3.value1) As employeeType, "
          . "(tax4.value1) As gender, "
          . "(tax5.value1) As faculty, "
          . "(tax6.value1) As department "
          . "FROM member mb "
          . "Left JOIN taxonomy tax1 "
          . "on mb.titleId = tax1.id "
          . "Left JOIN taxonomy tax2 "
          . "on mb.academicId = tax2.id "
          . "Left JOIN taxonomy tax3 "
          . "on mb.employeeTypeId = tax3.id "
          . "Left JOIN taxonomy tax4 "
          . "on mb.genderId = tax4.id "
          . "Left JOIN taxonomy tax5 "
          . "on mb.facultyId = tax5.id "
          . "Left JOIN taxonomy tax6 "
          . "on mb.departmentId = tax6.id "
          . "where mb.employeeTypeId=".$employeeTypeId." and " . $checkDateWork . " " . $checkAge . " " . $checkAgeWork . " " . $checkgenderId . "";

          $obj = $this->datacontext->pdoQuery($sql);

          return $obj;

          } 
    }

    public function previewsUserLists($id) {

        $view = new CJView("previews/lists", CJViewType::HTML_VIEW_ENGINE);

        $partCondition = '\\apps\\welfare\\entity\\';
     

        $sql = "SELECT cdt.conditionsId,cdt.welfareId,cdt.employeeTypeId, "
                . "cdt.dateStartWork,cdt.dateEndWork,cdt.ageStart,cdt.ageEnd,"
                . "cdt.ageWorkStart,cdt.ageWorkEnd,cdt.employeeTypeId,cdt.genderId "
                . "FROM " . $partCondition . "Conditions cdt "
                . "where cdt.conditionsId = :id";

        $obj = $this->datacontext->getObject($sql, array("id" => $id));
       
        $view->datas = $obj;
        
        return $view;
    }

    //end page conditions view lists
}
