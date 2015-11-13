<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\user\interfaces\IViewService;
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

        $view = new CJView("member/add", CJViewType::HTML_VIEW_ENGINE);
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
        $view = new CJView("member/edit", CJViewType::HTML_VIEW_ENGINE);
//        $member = new \apps\member\entity\Member();
//        $member->setMemberId($id);
        $sql = "select (title.value1) As titlename,"
                . "mem.fname,mem.lname,mem.idCard,mem.memberId,mem.employeeCode,mem.internalPhone,mem.phone,mem.mobile,"
                . "mem.email,mem.salary,mem.address,"
                . "(academic.value1) As academicname,(employeeT.value1) As employeeType,(pos.value1) As position,"
                . "(fa.value1) As faculty,(dep.value1) As department,(mat.value1) As matier,(userT.value1) As userType,mem.academicId "
                . "FROM apps\\member\\model\\Member mem "
                . "LEFT JOIN apps\\taxonomy\\entity\\Taxonomy academic "
                . "with mem.academicId = academic.id "
                . "LEFT JOIN apps\\taxonomy\\entity\\Taxonomy title "
                . "with mem.titleNameId = title.id "
                . "LEFT JOIN apps\\taxonomy\\entity\\Taxonomy employeeT "
                . "with mem.employeeTypeId = employeeT.id "
                . "LEFT JOIN apps\\taxonomy\\entity\\Taxonomy pos "
                . "with mem.positionId = pos.id "
                . "LEFT JOIN apps\\taxonomy\\entity\\Taxonomy fa "
                . "with mem.facultyId = fa.id "
                . "LEFT JOIN apps\\taxonomy\\entity\\Taxonomy dep "
                . "with mem.departmentId = dep.id "
                . "LEFT JOIN apps\\taxonomy\\entity\\Taxonomy mat "
                . "with mem.matierId = mat.id "
                . "LEFT JOIN apps\\user\\entity\\User user "
                . "with mem.memberId = user.memberId "
                . "LEFT JOIN apps\\taxonomy\\entity\\Taxonomy userT "
                . "with user.userId = userT.id "
                . "WHERE mem.memberId = :memberId";
        $param = array('memberId' => $id);
        $member = $this->datacontext->getObject($sql, $param);
        //print_r($member->fname);
//        $dob = $member->dob->format('d-m-Y');
//        
//        $mem = explode("-", $dob);
//        $member->dob = $mem[0] . "-" . $mem[1] . "-" . (intval($mem[2]) + 543);
//
//        $workStartDate = $member->workStartDate->format('d-m-Y');
//        $wsd = explode("-", $workStartDate);
//        $member->workStartDate = $wsd[0] . "-" . $wsd[1] . "-" . (intval($wsd[2]) + 543);
//        $user = new \apps\user\entity\User();
//        $user->memberId = $member->memberId;
//        $user = $this->datacontext->getObject($user)[0];
//        $member->userTypeId = $user->userTypeId;
        $view->datas = $member;
        return $view;
    }

    public function memberLists() {
        $view = new CJView("member/lists", CJViewType::HTML_VIEW_ENGINE);
        $searchName = $this->getRequest()->searchName;
        $filterCode = $this->getRequest()->filterCode;
        $filtervalue = $this->getRequest()->filtervalue;
        $datafilter = $this->getRequest();
        $sql = "select * ,IFNULL(mem1.academic1,mem1.titleName1) title "
                . "FROM v_fullmember mem1 "
                . "WHERE mem1.memberActive2 = 'Working'  ";
         
        if ($searchName != "") {
            
            $search = new MemberService();
            $view->searchvalue = $searchName;
            $view->lists = $search->search($datafilter);
        } else if ($filterCode != "") {
            
            $filter = new MemberService();
            $view->filterCode = $filterCode;
            $view->filterValue = $filtervalue;
            $view->lists = $filter->search($datafilter);
        } else {
            $view->lists = $this->datacontext->pdoQuery($sql); //กรณีที่ไม่ได้ search
            $view->faculty = $this->taxonomy->getPCode("faculty");
            $view->employeeType = $this->taxonomy->getPCode("employeeType");
            $view->memberActive = $this->taxonomy->getPCode("memberActive");
        }
        return $view;
    }

    public function memberPassword($id) {
        $view = new CJView("member/password", CJViewType::HTML_VIEW_ENGINE);
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
