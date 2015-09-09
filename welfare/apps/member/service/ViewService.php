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
            print_r("admin");
            $view = new CJView("admin/edit", CJViewType::HTML_VIEW_ENGINE);
            $member = new \apps\member\entity\Member();
            $member->setMemberId($id);
            $member = $this->datacontext->getObject($member)[0];

            $dob = $member->dob->format('d-m-Y');
            $mem = explode("-", $dob);
            $member->dob = $mem[0] . "-" . $mem[1] . "-" . (intval($mem[2]) + 543);

            $workStartDate = $member->workStartDate->format('d-m-Y');
            $wsd = explode("-", $workStartDate);
            $member->workStartDate = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);

            $user = new \apps\user\entity\User();
            $user->memberId = $member->memberId;
            $user = $this->datacontext->getObject($user)[0];
            $member->userTypeId = $user->userTypeId;
            $view->datas = $member;
            return $view;
        } else if ($usertype == "adminFaculty") {
            print_r("adminFaculty");
            $view = new CJView("faculty/edit", CJViewType::HTML_VIEW_ENGINE);
            $member = new \apps\member\entity\Member();
            $member->setMemberId($id);
            $member = $this->datacontext->getObject($member)[0];

            $dob = $member->dob->format('d-m-Y');
            $mem = explode("-", $dob);
            $member->dob = $mem[0] . "-" . $mem[1] . "-" . (intval($mem[2]) + 543);

            $workStartDate = $member->workStartDate->format('d-m-Y');
            $wsd = explode("-", $workStartDate);
            $member->workStartDate = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);

            $user = new \apps\user\entity\User();
            $user->memberId = $member->memberId;
            $user = $this->datacontext->getObject($user)[0];
            $member->userTypeId = $user->userTypeId;
            $view->datas = $member;
            return $view;
        } else if ($usertype == "adminDepartment") {
            print_r("adminDepartment");
            $view = new CJView("department/edit", CJViewType::HTML_VIEW_ENGINE);
            $member = new \apps\member\entity\Member();
            $member->setMemberId($id);
            $member = $this->datacontext->getObject($member)[0];

            $dob = $member->dob->format('d-m-Y');
            $mem = explode("-", $dob);
            $member->dob = $mem[0] . "-" . $mem[1] . "-" . (intval($mem[2]) + 543);

            $workStartDate = $member->workStartDate->format('d-m-Y');
            $wsd = explode("-", $workStartDate);
            $member->workStartDate = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);

            $user = new \apps\user\entity\User();
            $user->memberId = $member->memberId;
            $user = $this->datacontext->getObject($user)[0];
            $member->userTypeId = $user->userTypeId;
            $view->datas = $member;
            return $view;
        }
    }

    public function memberLists() {
        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
        $searchName = $this->getRequest()->searchName;
        $param = array();
        $sql = "select (tax1.value1) As titlename,mem1.fname,mem1.lname,mem1.idCard,mem1.memberId,(tax3.value1) as faculty,(tax4.value1) as department "
                . "FROM apps\\member\\entity\\Member mem1 "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax1 "
                . "with mem1.titleId = tax1.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax2 "
                . "with mem1.memberActiveId = tax2.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax3 "
                . "with mem1.facultyId = tax3.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax4 "
                . "with mem1.departmentId = tax4.id "
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
            $view->lists = $this->datacontext->getObject($sql, $param); //กรณีที่ไม่ได้ search
        }
        return $view;
    }

    public function memberShow($id) {
        $view = new CJView("user/profile", CJViewType::HTML_VIEW_ENGINE);
        $member = new \apps\member\entity\Member();
        $member->setMemberId($id);
        $member = $this->datacontext->getObject($member)[0];

        $dob = $member->dob->format('d-m-Y');
        $mem = explode("-", $dob);
        $member->dob = $mem[0] . "-" . $mem[1] . "-" . (intval($mem[2]) + 543);

        $workStartDate = $member->workStartDate->format('d-m-Y');
        $wsd = explode("-", $workStartDate);
        $member->workStartDate = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);

        $user = new \apps\user\entity\User();
        $user->memberId = $member->memberId;
        $user = $this->datacontext->getObject($user)[0];
        $member->userTypeId = $user->userTypeId;
        $view->datas = $member;
        return $view;
    }

    public function editProfile($id) {
        $view = new CJView("user/editProfile", CJViewType::HTML_VIEW_ENGINE);
        $member = new \apps\member\entity\Member();
        $member->setMemberId($id);
        $member = $this->datacontext->getObject($member)[0];

        $dob = $member->dob->format('d-m-Y');
        $mem = explode("-", $dob);
        $member->dob = $mem[0] . "-" . $mem[1] . "-" . (intval($mem[2]) + 543);

        $workStartDate = $member->workStartDate->format('d-m-Y');
        $wsd = explode("-", $workStartDate);
        $member->workStartDate = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);

        $user = new \apps\user\entity\User();
        $user->memberId = $member->memberId;
        $user = $this->datacontext->getObject($user)[0];
        $member->userTypeId = $user->userTypeId;
        $view->datas = $member;
        return $view;
    }

}
