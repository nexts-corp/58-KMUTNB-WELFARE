<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\user\interfaces\IMemberService;
use \apps\common\entity\Register;
use apps\user\entity\User;
use \apps\common\entity\Department;

class MemberService extends CServiceBase implements IMemberService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function save($data) {

        $data->dob = new \DateTime($data->dob);
        $data->workStartDate = new \DateTime($data->workStartDate);
//        return $data;
        if ($this->datacontext->saveObject($data)) {

            $user = new User();
//            $user->setRegisterId($data->memberId);
//            $user->setUserName($data->registerIdCard);
//            $user->setUserTypeId($data->userTypeId);
//            $aa = $data->registerDateOfBirth->format('d-m-Y');
//            $user->setPassword(md5($aa));
            
            $user->setMemberId($data->memberId);
            $user->setUsername($data->idCard);
            $user->setUserTypeId($data->userTypeId);
            $aa = $data->dob->format('d-m-Y');
            $user->setPassword(md5($aa));

//            if ($data->checkUser == "1") {
//                $user->setSuperAdminId($data->SuperAdminId);
//            } elseif ($data->checkUser == "2") {
//                $user->setFacultyId($data->facultyId);
//            } elseif ($data->checkUser == "3") {
//                $user->setFacultyId($data->facultyId);
//                $user->setDepartmentId($data->departmentId);
//            }
            if ($this->datacontext->saveObject($user)) {
                $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");

                return true;
            } else {
                $this->getResponse()->add("message", $this->datacontext->getLastMessage());
                return false;
            }
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function update($data) {
        $data->dob = new \DateTime($data->dob);
        $data->workStartDate = new \DateTime($data->workStartDate);
        if ($this->datacontext->updateObject($data)) {
            $this->getResponse()->add("message", "อัพเดทข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function delete($memberId) {
        $taxonomy = new \apps\taxonomy\entity\Taxonomy();
        $taxonomy->pCode = "memberActive";
        $taxonomy->code = "leave";
        $dataTax = $this->datacontext->getObject($taxonomy)[0];

        $member= new \apps\member\entity\Member();
        $member->memberId = $memberId;
        $dataMem = $this->datacontext->getObject($member)[0];
        
        $dataMem->memberActiveId = $dataTax->id;
        $dataMem->workEndDate = new \DateTime('now');
        
        return $this->datacontext->updateObject($dataMem);
    }

    public function getDepartment($id) {

        $view = new CJView("member/get/data", CJViewType::HTML_VIEW_ENGINE);
        $filter = new Department();
        $filter->setFacultyId($id);
        $dao_department = $this->datacontext->getObject($filter);
        $view->data = $dao_department;
        return $view;
    }

    public function getData($id) {

        $view = new CJView("member/get/data", CJViewType::HTML_VIEW_ENGINE);
        $filter = new Department();
        $filter->setFacultyId($id);
        $dao_department = $this->datacontext->getObject($filter);
        $view->data = $dao_department;
        return $view;
    }

}
