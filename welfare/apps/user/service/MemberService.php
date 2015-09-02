<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\user\interfaces\IMemberService;

use apps\user\entity\User;


class MemberService extends CServiceBase implements IMemberService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function save($data) {
        $taxonomy = new \apps\taxonomy\entity\Taxonomy();
        $taxonomy->pCode = "memberActive";
        $taxonomy->code = "working";
        $dataTax = $this->datacontext->getObject($taxonomy)[0];
        
        $data->memberActiveId = $dataTax->id;
        
        $dob1 = explode("-",$data->dob);
        $dob1[2] = intVal($dob1[2])-543;
        $dob = $dob1[2]."-".$dob1[1]."-".$dob1[0];
        
        $date1 = explode("-",$data->workStartDate);
        $date1[2] = intVal($date1[2])-543;
        $workStartDate = $date1[2]."-".$date1[1]."-".$date1[0];
        
        $data->dob = new \DateTime($dob);
        
        $data->workStartDate = new \DateTime($workStartDate);
//        
//        $data->dob = $data->dob->format('Y-m-d');
//        $data->workStartDate = $data->workStartDate->format('Y-m-d');
        //print_r($data);
//        return $data;
        if ($this->datacontext->saveObject($data)) {

            $user = new User();
         
            
            $user->setMemberId($data->memberId);
            $user->setUsername($data->idCard);
            $user->setUserTypeId($data->userTypeId);
            $dob = $data->dob->format('d-m-Y');
            $pwd = explode("-",$dob);
            $password = $pwd[0].$pwd[1].(intval($pwd[2])+543);
            $user->setPassword(md5($password));

         
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
        $dob1 = explode("-",$data->dob);
        $dob1[2] = intVal($dob1[2])-543;
        $dob = $dob1[2]."-".$dob1[1]."-".$dob1[0];
        
        $date1 = explode("-",$data->workStartDate);
        $date1[2] = intVal($date1[2])-543;
        $workStartDate = $date1[2]."-".$date1[1]."-".$date1[0];
        
        $data->dob = new \DateTime($dob);
        
        $data->workStartDate = new \DateTime($workStartDate);
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

    public function search($data) {
        $view = new CJView("member/lists", CJViewType::HTML_VIEW_ENGINE);
        //print_r($data);
                
        $sql="select  mem.memberId,mem.idCard,mem.titleId,mem.academicId,mem.fname,mem.lname, "
                . "tax.pCode,tax.code "
                . "FROM \\apps\\member\\entity\\Member mem "
                . "INNER JOIN \\apps\\taxonomy\\entity\\Taxonomy tax "
                . "with mem.memberActiveId = tax.id "
                . "WHERE tax.pCode = 'memberActive' and tax.code = 'working' "
                . "and mem.fname LIKE :name or mem.lname LIKE :name or mem.idCard LIKE :name ";
        //print_r($sql);
        $view->list = $this->datacontext->getObject($sql,array("name"=>"%".$data."%"));
//        print_r($view->datas);
        return $view;
    }

}
