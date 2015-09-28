<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\member\interfaces\IViewService;
use apps\taxonomy\entity\Taxonomy;
use apps\taxonomy\service\TaxonomyService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext("default");
        $this->taxonomy = new TaxonomyService();
    }

    public function memberAdd() {
        $view = new CJView("admin/add", CJViewType::HTML_VIEW_ENGINE);
//        $academic = new Taxonomy();
//        $academic->pCode = "academic";
        $view->academic = $this->taxonomy->getPCode("academic");


        $view->titleName = $this->taxonomy->getPCode("titleName");

        $view->gender = $this->taxonomy->getPCode("gender");

        $view->employeeType = $this->taxonomy->getPCode("employeeType");

        $view->position = $this->taxonomy->getPCode("position");

        $view->department = $this->taxonomy->getPCode("department");

        $view->faculty = $this->taxonomy->getPCode("faculty");

        $view->userType = $this->taxonomy->getPCode("userType");

        $view->matier = $this->taxonomy->getPCode("matier");

        return $view;
    }

    public function memberEdit($id) {
        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;

        if ($usertype == "administrator") {
            $view = new CJView("admin/edit", CJViewType::HTML_VIEW_ENGINE);
        } else if ($usertype == "adminFaculty") {
            $view = new CJView("faculty/edit", CJViewType::HTML_VIEW_ENGINE);
        } else if ($usertype == "adminDepartment") {
            $view = new CJView("department/edit", CJViewType::HTML_VIEW_ENGINE);
        } else if ($usertype == "user") {
            $view = new CJView("user/editProfile", CJViewType::HTML_VIEW_ENGINE);
        } else if ($usertype == "adminMedical") {
            $view = new CJView("user/editProfile", CJViewType::HTML_VIEW_ENGINE);
        }
        $sql = "select mem1 "
                . "FROM apps\\member\\model\\FullMember mem1 "
                . "WHERE mem1.memberActive2 = 'Working' and mem1.memberId=:id ";

        $param["id"] = $id;
        $member = $this->datacontext->getObject($sql, $param);
//            $Y=Date("Y")+543;
//        print_r($member);
//        exit();
//        $dob = $member[0]['dob']->format('d-m-Y');
//        print_r($member);


        $mem = explode("-", $member[0]->dob);
        $member[0]->dob = $mem[2] . "-" . $mem[1] . "-" . (intval($mem[0]) + 543);

//        $workStartDate = $member[0]['workStartDate']->format('d-m-Y');
        $wsd = explode("-", $member[0]->workStartDate);
        $member[0]->workStartDate = $wsd[2] . "-" . $wsd[1] . "-" . (intval($wsd[0]) + 543);

//        $salaryDate = $member[0]['salaryDate']->format('d-m-Y');
        $wsd = explode("-", $member[0]->salaryDate);
        $member[0]->salaryDate = $wsd[2] . "-" . $wsd[1] . "-" . (intval($wsd[0]) + 543);

        $user = new \apps\user\entity\User();
        $user->memberId = $member[0]->memberId;
        $user = $this->datacontext->getObject($user)[0];
        $member[0]->userTypeId = $user->userTypeId;
        $view->datas = $member;
//        print_r($member);
//        exit();
        $academic = new Taxonomy();
        $academic->pCode = "academic";
        $view->academic = $this->datacontext->getObject($academic);

        $titleName = new Taxonomy();
        $titleName->pCode = "titleName";
        $view->titleName = $this->datacontext->getObject($titleName);

        $gender = new Taxonomy();
        $gender->pCode = "gender";
        $view->gender = $this->datacontext->getObject($gender);

        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);

        $position = new Taxonomy();
        $position->pCode = "position";
        $view->position = $this->datacontext->getObject($position);


        $faculty = new Taxonomy();
        $faculty->pCode = "faculty";
        $view->faculty = $this->datacontext->getObject($faculty);

        $userType = new Taxonomy();
        $userType->pCode = "userType";
        $view->userType = $this->datacontext->getObject($userType);

        $matier = new Taxonomy();
        $matier->pCode = "matier";
        $view->matier = $this->datacontext->getObject($matier);

        return $view;
    }

    public function memberLists() {

        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
        $searchName = $this->getRequest()->searchName;
        $filterCode = $this->getRequest()->filterCode;
        $filtervalue = $this->getRequest()->filtervalue;
        $datafilter = $this->getRequest();

        

        $param = array();
        $sql = "select mem1 "
                . "FROM apps\\member\\model\\FullMember mem1 ";

        if ($usertype == "administrator") {
            $view = new CJView("admin/lists", CJViewType::HTML_VIEW_ENGINE);
            $sql .= "WHERE mem1.memberActive2 = 'Working'  ";
        } elseif ($usertype == "adminFaculty") {
            $view = new CJView("faculty/lists", CJViewType::HTML_VIEW_ENGINE);

            $sql .= "join apps\\taxonomy\\entity\\Taxonomy "
                    . "tax with tax.id = mem1.facultyId "
                    . "WHERE mem1.memberActive2 = 'Working' "
                    . "and tax.code = :facultyId "; //กรณีที่ไม่ได้ search
            $param["facultyId"] = $facultyId;
        } elseif ($usertype == "adminDepartment") {
            $view = new CJView("department/lists", CJViewType::HTML_VIEW_ENGINE);
            
             $sql .="join apps\\taxonomy\\entity\\Taxonomy "
                    . "tax with tax.id = mem1.departmentId "
                    . "WHERE mem1.memberActive2 = 'Working' "
                    . "and tax.code = :departmentId ";  //กรณีที่ไม่ได้ search
            $param["departmentId"] = $departmentId;
        }

        if ($searchName != "") {

            $search = new MemberService();
            $view->lists = $search->search($datafilter);
        } else if ($filterCode != "") {

            $filter = new MemberService();
            $view->lists = $filter->search($datafilter);
        } else {
            $view->lists = $this->datacontext->getObject($sql, $param); //กรณีที่ไม่ได้ search
        }
        return $view;
    }

    public function memberShow($id) {
        $view = new CJView("user/profile", CJViewType::HTML_VIEW_ENGINE);
        $sql = "select mem1 "
                . "FROM apps\\member\\model\\FullMember mem1 "
                . "WHERE mem1.memberActive2 = 'Working' and mem1.memberId=:id ";

        $param["id"] = $id;
        $member = $this->datacontext->getObject($sql, $param);
//            $Y=Date("Y")+543;
//        exit();
//        print_r($member);
//        exit();
        //$dob = $member->dob->format('d-m-Y');


        $mem = explode("-", $member[0]->dob);
        $member[0]->dob = $mem[2] . "-" . $mem[1] . "-" . (intval($mem[0]) + 543);

//        $workStartDate = $member[0]['workStartDate']->format('d-m-Y');
        $wsd = explode("-", $member[0]->workStartDate);
        $member[0]->workStartDate = $wsd[2] . "-" . $wsd[1] . "-" . (intval($wsd[0]) + 543);

//        $salaryDate = $member[0]['salaryDate']->format('d-m-Y');
        $wsd = explode("-", $member[0]->salaryDate);
        $member[0]->salaryDate = $wsd[2] . "-" . $wsd[1] . "-" . (intval($wsd[0]) + 543);
//        print_r($member);
//        exit();
        $user = new \apps\user\entity\User();
        $user->memberId = $member[0]->memberId;
        $user = $this->datacontext->getObject($user)[0];
        $member[0]->userTypeId = $user->userTypeId;
        $academic = new Taxonomy();
        $academic->pCode = "academic";
        $view->academic = $this->datacontext->getObject($academic);

        $titleName = new Taxonomy();
        $titleName->pCode = "titleName";
        $view->titleName = $this->datacontext->getObject($titleName);

        $gender = new Taxonomy();
        $gender->pCode = "gender";
        $view->gender = $this->datacontext->getObject($gender);

        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);

        $position = new Taxonomy();
        $position->pCode = "position";
        $view->position = $this->datacontext->getObject($position);


        $faculty = new Taxonomy();
        $faculty->pCode = "faculty";
        $view->faculty = $this->datacontext->getObject($faculty);

        $userType = new Taxonomy();
        $userType->pCode = "userType";
        $view->userType = $this->datacontext->getObject($userType);

        $matier = new Taxonomy();
        $matier->pCode = "matier";
        $view->matier = $this->datacontext->getObject($matier);
        $view->datas = $member;
        return $view;
    }

    public function historyEdit($id) {
        $view = new CJView("admin/history", CJViewType::HTML_VIEW_ENGINE);
//        $mhis = new \apps\member\entity\History();
//        $mhis->setMemberId($id);
//        $history = $this->datacontext->getObject($mhis);

        $sql = "select * "
                . "FROM memberhistory mhis "
                . "WHERE mhis.memberId=$id ";
        $history = $this->datacontext->pdoQuery($sql);

        $sql1 = "select * "
                . "FROM memberhistory mhis "
                . "WHERE mhis.entityChange = 'member' and mhis.memberId=$id ";
        $mem = $this->datacontext->pdoQuery($sql1);

        $sql2 = "select * "
                . "FROM memberhistory mhis "
                . "WHERE mhis.entityChange = 'contact' and mhis.memberId=$id ";
        $contact = $this->datacontext->pdoQuery($sql2);

        $sql3 = "select * "
                . "FROM memberhistory mhis "
                . "WHERE mhis.entityChange = 'salary' and mhis.memberId=$id ";
        $salary = $this->datacontext->pdoQuery($sql3);

        $sql4 = "select *, taxo.value1 as older, taxn.value1 as newdata "
                . "FROM memberhistory mhis "
                . "left join taxonomy taxo "
                . "on taxo.id = mhis.valueOld "
                . "left join taxonomy taxn "
                . "on taxn.id = mhis.valueNew "
                . "WHERE mhis.entityChange = 'work' and mhis.memberId=$id ";
        $work = $this->datacontext->pdoQuery($sql4);

        $sql5 = "select * "
                . "FROM memberdocument mdoc "
                . "WHERE  mdoc.memberId=$id ";
        $ref = $this->datacontext->pdoQuery($sql5);

        $member = new \apps\member\model\FullMember();
        $member->memberId = $id;
        $member = $this->datacontext->getObject($member);
        foreach ($mem as $key => $field) {

            if ($mem[$key]['fieldChange'] == "idCard") {
                $mem[$key]['fieldChange'] = "รหัสบัตรประชาชน";
            }
            if ($mem[$key]['fieldChange'] == "genderId") {
                $mem[$key]['fieldChange'] = "เพศ";
            }
            if ($mem[$key]['fieldChange'] == "titleNameId") {
                $mem[$key]['fieldChange'] = "คำนำหน้า";
            }
            if ($mem[$key]['fieldChange'] == "academicId") {
                $mem[$key]['fieldChange'] = "ตำแหน่งทางวิชาการ";
            }
            if ($mem[$key]['fieldChange'] == "fname") {
                $mem[$key]['fieldChange'] = "ชื่อ";
            }
            if ($mem[$key]['fieldChange'] == "lname") {
                $mem[$key]['fieldChange'] = "นามสกุล";
            }
            if ($mem[$key]['fieldChange'] == "dob") {
                $mem[$key]['fieldChange'] = "วันเกิด";
            }
            if ($mem[$key]['fieldChange'] == "employeeCode") {
                $mem[$key]['fieldChange'] = "เลขที่อัตรา";
            }
            if ($mem[$key]['fieldChange'] == "workStartDate") {
                $mem[$key]['fieldChange'] = "วันที่เริ่มงาน";
            }
            if ($mem[$key]['fieldChange'] == "document") {
                $mem[$key]['fieldChange'] = "เอกสารอ้างอิง";
            }
            if ($mem[$key]['fieldChange'] == "remark") {
                $mem[$key]['fieldChange'] = "หมายเหตุ";
            }
        }

        foreach ($work as $key => $field2) {

            if ($work[$key]['fieldChange'] == "positionId") {
                $work[$key]['fieldChange'] = "ตำแหน่งงาน";
            }
            if ($work[$key]['fieldChange'] == "matierId") {
                $work[$key]['fieldChange'] = "สายงาน";
            }
            if ($work[$key]['fieldChange'] == "departmentId") {
                $work[$key]['fieldChange'] = "สาขา/หน่วยงาน/ภาค";
            }
            if ($work[$key]['fieldChange'] == "facultyId") {
                $work[$key]['fieldChange'] = "คณะ/หน่วยงาน/สำนัก";
            }
            if ($work[$key]['fieldChange'] == "employeeTypeId") {
                $work[$key]['fieldChange'] = "ประเภทพนักงาน";
            }
        }

        foreach ($contact as $key => $field3) {

            if ($contact[$key]['fieldChange'] == "address") {
                $contact[$key]['fieldChange'] = "ที่อยู่";
            }
            if ($contact[$key]['fieldChange'] == "internalPhone") {
                $contact[$key]['fieldChange'] = "เบอร์โทรศัพท์ภายใน";
            }
            if ($contact[$key]['fieldChange'] == "phone") {
                $contact[$key]['fieldChange'] = "เบอร์โทรศัพท์";
            }
            if ($contact[$key]['fieldChange'] == "mobile") {
                $contact[$key]['fieldChange'] = "เบอร์มือถือ";
            }
            if ($contact[$key]['fieldChange'] == "email") {
                $contact[$key]['fieldChange'] = "อีเมล์";
            }
        }
        foreach ($salary as $key => $field4) {

            if ($salary[$key]['fieldChange'] == "rank") {
                $salary[$key]['fieldChange'] = "ลำดับขั้น";
            }
            if ($salary[$key]['fieldChange'] == "salary") {
                $salary[$key]['fieldChange'] = "เงินเดือน";
            }
            if ($salary[$key]['fieldChange'] == "salaryDate") {
                $salary[$key]['fieldChange'] = "วันที่ปรับเงินเดือน";
            }
        }
        foreach ($history as $key => $field5) {
            if ($history[$key]['fieldChange'] == "idCard") {
                $history[$key]['fieldChange'] = "รหัสบัตรประชาชน";
            }
            if ($history[$key]['fieldChange'] == "genderId") {
                $history[$key]['fieldChange'] = "เพศ";
            }
            if ($history[$key]['fieldChange'] == "titleNameId") {
                $history[$key]['fieldChange'] = "คำนำหน้า";
            }
            if ($history[$key]['fieldChange'] == "academicId") {
                $history[$key]['fieldChange'] = "ตำแหน่งทางวิชาการ";
            }
            if ($history[$key]['fieldChange'] == "fname") {
                $history[$key]['fieldChange'] = "ชื่อ";
            }
            if ($history[$key]['fieldChange'] == "lname") {
                $history[$key]['fieldChange'] = "นามสกุล";
            }
            if ($history[$key]['fieldChange'] == "dob") {
                $history[$key]['fieldChange'] = "วันเกิด";
            }
            if ($history[$key]['fieldChange'] == "employeeCode") {
                $history[$key]['fieldChange'] = "เลขที่อัตรา";
            }
            if ($history[$key]['fieldChange'] == "workStartDate") {
                $history[$key]['fieldChange'] = "วันที่เริ่มงาน";
            }
            if ($history[$key]['fieldChange'] == "document") {
                $history[$key]['fieldChange'] = "เอกสารอ้างอิง";
            }
            if ($history[$key]['fieldChange'] == "remark") {
                $history[$key]['fieldChange'] = "หมายเหตุ";
            }
            if ($history[$key]['fieldChange'] == "positionId") {
                $history[$key]['fieldChange'] = "ตำแหน่งงาน";
            }
            if ($history[$key]['fieldChange'] == "matierId") {
                $history[$key]['fieldChange'] = "สายงาน";
            }
            if ($history[$key]['fieldChange'] == "departmentId") {
                $history[$key]['fieldChange'] = "สาขา/หน่วยงาน/ภาค";
            }
            if ($history[$key]['fieldChange'] == "facultyId") {
                $history[$key]['fieldChange'] = "คณะ/หน่วยงาน/สำนัก";
            }
            if ($history[$key]['fieldChange'] == "employeeTypeId") {
                $history[$key]['fieldChange'] = "ประเภทพนักงาน";
            }
            if ($history[$key]['fieldChange'] == "address") {
                $history[$key]['fieldChange'] = "ที่อยู่";
            }
            if ($history[$key]['fieldChange'] == "internalPhone") {
                $history[$key]['fieldChange'] = "เบอร์โทรศัพท์ภายใน";
            }
            if ($history[$key]['fieldChange'] == "phone") {
                $history[$key]['fieldChange'] = "เบอร์โทรศัพท์";
            }
            if ($history[$key]['fieldChange'] == "mobile") {
                $history[$key]['fieldChange'] = "เบอร์มือถือ";
            }
            if ($history[$key]['fieldChange'] == "email") {
                $history[$key]['fieldChange'] = "อีเมล์";
            }
            if ($history[$key]['fieldChange'] == "rank") {
                $history[$key]['fieldChange'] = "ลำดับขั้น";
            }
            if ($history[$key]['fieldChange'] == "salary") {
                $history[$key]['fieldChange'] = "เงินเดือน";
            }
            if ($history[$key]['fieldChange'] == "salaryDate") {
                $history[$key]['fieldChange'] = "วันที่ปรับเงินเดือน";
            }
            
           //print_r($history[$key]['valueOld']);
           
          $xx=explode("-",$history[$key]['valueOld']);
          if(count($xx)==3)
          {
              $history[$key]['valueOld'] =  $xx[2]."-".$xx[1]."-".($xx[0]+543);
//              echo $history[$key]['valueOld'];
          }
          $xx=explode("-",$history[$key]['valueOld']);
          if(count($xx)==3)
          {
              $history[$key]['valueOld'] =  $xx[2]."-".$xx[1]."-".($xx[0]+543);
//              echo $history[$key]['valueOld'];
          }
          
//           if($history[$key]['valueOld']=="--"){
//           $time=explode("-",$history[$key]['valueOld']);
//           
//          // $hestory=$time[0]."-".$time[1]."-".$time[2];
//           print($history[$key]['valueOld']);
//           }
           //exit();
//            
//            if (strstr($history[$key]['valueOld'], "-")) {
//
//                $history[$key]['valueOld'] = $history[$key]['valueOld']->format('Y-m-d');
//                $history[$key]['valueNew'] = $history[$key]['valueNew']->format('Y-m-d');
//                print_r($history[$key]['valueNew']);
//                exit();
//            }
        }

        $view->member = $member;
        $view->work = $work;
        $view->salary = $salary;
        $view->contact = $contact;
        $view->memhis = $mem;
        $view->lists = $history;
        $view->ref = $ref;
        return $view;
    }

}
