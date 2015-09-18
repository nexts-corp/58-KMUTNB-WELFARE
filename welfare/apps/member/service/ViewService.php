<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\member\interfaces\IViewService;
use apps\taxonomy\entity\Taxonomy;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function memberAdd() {
        $view = new CJView("admin/add", CJViewType::HTML_VIEW_ENGINE);
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

        $department = new Taxonomy();
        $department->pCode = "department";
        $view->department = $this->datacontext->getObject($department);

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
        }else if ($usertype == "adminMedical") {
            $view = new CJView("user/editProfile", CJViewType::HTML_VIEW_ENGINE);
        }
        $sql = "select mem1.fname,mem1.lname,mem1.idCard,mem1.memberId,(fac.value1) as faculty,(depart.value1) as department, "
                . "aca.value1 as academic,mem1.titleNameId,title.value1 as titlename ,mem1.genderId,gende.value1 as gender,mem1.dob,mem1.employeeCode, "
                . "mem1.employeeTypeId,mem1.facultyId,mem1.departmentId,mem1.positionId,mem1.matierId,mem1.internalPhone,mem1.academicId, "
                . "mem1.phone,mem1.mobile,mem1.email,mem1.salaryDate,mem1.salary,emp.value1 as employeetype,psw.value1 as positionwork, "
                . "mem1.address,mem1.workStartDate,mem1.workEndDate,mem1.memberActiveId,mat.value1 as matier "
                . "FROM apps\\member\\model\\Member mem1 "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy title "
                . "with mem1.titleNameId = title.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy gende "
                . "with mem1.genderId = gende.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy fac "
                . "with mem1.facultyId = fac.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy depart "
                . "with mem1.departmentId = depart.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy mat "
                . "with mem1.matierId = mat.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy aca "
                . "with mem1.academicId = aca.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy emp "
                . "with mem1.employeeTypeId = emp.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy psw "
                . "with mem1.positionId = psw.id "
                . "WHERE mem1.memberId=$id ";

        $member = $this->datacontext->getObject($sql);
//            $Y=Date("Y")+543;
//        print_r($member);
//        exit();
        $dob = $member[0]['dob']->format('d-m-Y');

//        print_r($member);
        
        $mem = explode("-", $dob);
        $member[0]['dob'] = $mem[0] . "-" . $mem[1] . "-" . (intval($mem[2]) + 543);

        $workStartDate = $member[0]['workStartDate']->format('d-m-Y');
        $wsd = explode("-", $workStartDate);
        $member[0]['workStartDate'] = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);
        
        $salaryDate = $member[0]['salaryDate']->format('d-m-Y');
        $wsd = explode("-", $salaryDate);
        $member[0]['salaryDate'] = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);

        $user = new \apps\user\entity\User();
        $user->memberId = $member[0]['memberId'];
        $user = $this->datacontext->getObject($user)[0];
        $member[0]['userTypeId'] = $user->userTypeId;
        $view->datas = $member;
        
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
        $param = array();
        $sql = "select mem1.fname,mem1.lname,mem1.idCard,"
                . "mem1.memberId,(tax3.value1) as faculty,(tax4.value1) as department,"
                . "IFNULL(tax5.value1,tax1.value1) title "
                . "FROM v_member mem1 "
                . "INNER JOIN taxonomy tax1 "
                . "on mem1.titleNameId = tax1.id "
                . "INNER JOIN taxonomy tax2 "
                . "on mem1.memberActiveId = tax2.id "
                . "LEFT JOIN taxonomy tax3 "
                . "on mem1.facultyId = tax3.id "
                . "LEFT JOIN taxonomy tax4 "
                . "on mem1.departmentId = tax4.id "
                . "left JOIN taxonomy tax5 "
                . "on mem1.academicId = tax5.id "
                . "WHERE tax2.pCode = 'memberActive' and tax2.code = 'working' ";

        if ($usertype == "administrator") {
            $view = new CJView("admin/lists", CJViewType::HTML_VIEW_ENGINE);
        } elseif ($usertype == "adminFaculty") {
            $view = new CJView("faculty/lists", CJViewType::HTML_VIEW_ENGINE);

            $sql .= " and tax3.code = :facultyId "; //กรณีที่ไม่ได้ search
            $param["facultyId"] = $facultyId;
        } elseif ($usertype == "adminDepartment") {
            $view = new CJView("department/lists", CJViewType::HTML_VIEW_ENGINE);

            $sql .= " and tax4.code = :departmentId "; //กรณีที่ไม่ได้ search
            $param["departmentId"] = $departmentId;
        }

        if ($searchName != "") {
            $search = new MemberService();
            $view->lists = $search->search($searchName);
        } else {
            $view->lists = $this->datacontext->pdoQuery($sql, $param); //กรณีที่ไม่ได้ search
        }
        return $view;
    }

    public function memberShow($id) {
        $view = new CJView("user/profile", CJViewType::HTML_VIEW_ENGINE);
        $sql = "select mem1.fname,mem1.lname,mem1.idCard,mem1.memberId,(fac.value1) as faculty,(depart.value1) as department, "
                . "aca.value1 as academic,mem1.titleNameId,title.value1 as titlename ,mem1.genderId,gende.value1 as gender,mem1.dob,mem1.employeeCode, "
                . "mem1.employeeTypeId,mem1.facultyId,mem1.departmentId,mem1.positionId,mem1.matierId,mem1.internalPhone,mem1.academicId, "
                . "mem1.phone,mem1.mobile,mem1.email,mem1.salaryDate,mem1.salary,emp.value1 as employeetype,psw.value1 as positionwork, "
                . "mem1.address,mem1.workStartDate,mem1.workEndDate,mem1.memberActiveId,mat.value1 as matier "
                . "FROM apps\\member\\model\\Member mem1 "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy title "
                . "with mem1.titleNameId = title.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy gende "
                . "with mem1.genderId = gende.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy fac "
                . "with mem1.facultyId = fac.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy depart "
                . "with mem1.departmentId = depart.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy mat "
                . "with mem1.matierId = mat.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy aca "
                . "with mem1.academicId = aca.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy emp "
                . "with mem1.employeeTypeId = emp.id "
                . "left JOIN apps\\taxonomy\\entity\\Taxonomy psw "
                . "with mem1.positionId = psw.id "
                . "WHERE mem1.memberId=$id ";

        $member = $this->datacontext->getObject($sql);
//            $Y=Date("Y")+543;
        
//        exit();
        $dob = $member[0]['dob']->format('d-m-Y');
        
//        print_r($member);

        $mem = explode("-", $dob);
        $member[0]['dob'] = $mem[0] . "-" . $mem[1] . "-" . (intval($mem[2]) + 543);
        
        $workStartDate = $member[0]['workStartDate']->format('d-m-Y');
        $wsd = explode("-", $workStartDate);
        $member[0]['workStartDate'] = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);
        
        $salaryDate = $member[0]['salaryDate']->format('d-m-Y');
        $wsd = explode("-", $salaryDate);
        $member[0]['salaryDate'] = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);
//        print_r($member);
//        exit();
        $user = new \apps\user\entity\User();
        $user->memberId = $member[0]['memberId'];
        $user = $this->datacontext->getObject($user)[0];
        $member[0]['userTypeId'] = $user->userTypeId;
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

}
