<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\member\interfaces\IMemberService;
use apps\user\entity\User;
use apps\member\entity\Member;
use apps\member\entity\MemberHistory;

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

        $dob1 = explode("-", $data->dob);
        $dob1[2] = intVal($dob1[2]) - 543;
        $dob = $dob1[2] . "-" . $dob1[1] . "-" . $dob1[0];

        $date1 = explode("-", $data->workStartDate);
        $date1[2] = intVal($date1[2]) - 543;
        $workStartDate = $date1[2] . "-" . $date1[1] . "-" . $date1[0];

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
            $pwd = explode("-", $dob);
            $password = $pwd[0] . $pwd[1] . (intval($pwd[2]) + 543);
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
        if ($data->dob != "") {
            $dob1 = explode("-", $data->dob);
            $dob1[2] = intVal($dob1[2]) - 543;
            $dob = $dob1[2] . "-" . $dob1[1] . "-" . $dob1[0];
            $data->dob = new \DateTime($dob);
        }
        if ($data->workStartDate != "") {
            $date1 = explode("-", $data->workStartDate);
            $date1[2] = intVal($date1[2]) - 543;
            $workStartDate = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
            $data->workStartDate = new \DateTime($workStartDate);
        }


        $current = new Member();
        $current->memberId = $data->memberId;
        $current = $this->datacontext->getObject($current)[0];
        if ($data->userTypeId != "") {
            $user = new User();
            $user->memberId = $data->memberId;
            $dataUser = $this->datacontext->getObject($user)[0];
            //   print $data->userTypeId . " " . $dataUser->userTypeId;
            if ($data->userTypeId != $dataUser->userTypeId) {
                // print "!=";
                $history = new MemberHistory();
                $history->memberId = $data->memberId;
                $history->fieldChange = "userTypeId";
                $history->valueOld = $dataUser->userTypeId;
                $history->valueNew = $data->userTypeId;
                $this->datacontext->saveObject($history);

                $dataUser->userTypeId = $userTypeId;
                $this->datacontext->updateObject($dataUser);
            }
        }
        foreach ($data as $fieldNew => $valueNew) {
            if ($valueNew != null) {
                foreach ($current as $filedOld => $valueOld) {
                    if ($fieldNew == $filedOld) {
                        if ($valueNew != $valueOld || $fieldNew == "memberId") {
                            $history = new MemberHistory();
                            $history->memberId = $data->memberId;
                            $history->fieldChange = $filedOld;
                            if (is_a($valueOld, "DateTime")) { //if value is DateTime
//                            if ($filedOld == "workStartDate" || $filedOld == "workEndDate" || $filedOld == "dob") {
                                $history->valueOld = $valueOld->format('Y-m-d');
                                $history->valueNew = $valueNew->format('Y-m-d');
                                $this->datacontext->saveObject($history);
                            } elseif ($filedOld != "userTypeId") {
                                $history->valueOld = $valueOld;
                                $history->valueNew = $valueNew;
                                $this->datacontext->saveObject($history);
                            }
                        }
                    }
                }
            }
        }

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

        $member = new Member();
        $member->memberId = $memberId;
        $dataMem = $this->datacontext->getObject($member)[0];

        $dataMem->memberActiveId = $dataTax->id;
        $dataMem->workEndDate = new \DateTime('now');

        if ($this->datacontext->updateObject($dataMem)) {
            $this->getResponse()->add("message", "อัพเดทข้อมูลสำเร็จ");
            return true;
        } else {
//            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function search($data) {
        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
        $param = array(
            "name" => "%" . $data . "%"
        );
        $sql = "select tax1.value1 As titlename, "
                . "mem1.fname,mem1.lname,mem1.idCard,mem1.memberId, "
                . "tax3.value1 as faculty, "
                . "tax4.value1 as department "
                . "FROM apps\\member\\entity\\Member mem1 "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax1 "
                . "with mem1.titleId = tax1.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax2 "
                . "with mem1.memberActiveId = tax2.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax3 "
                . "with mem1.facultyId = tax3.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax4 "
                . "with mem1.departmentId = tax4.id "
                . "WHERE tax2.pCode = 'memberActive' and tax2.code = 'working' "
                . "and (mem1.fname LIKE :name or mem1.lname LIKE :name or mem1.idCard LIKE :name) ";
        if ($usertype == "administrator") {
            
        } elseif ($usertype == "adminFaculty") {
            $sql .= " and tax3.code = :facultyId ";
            $param["facultyId"] = $facultyId;
        } elseif ($usertype == "adminDepartment") {
            $sql .= " and tax4.code = :departmentId ";
            $param["departmentId"] = $departmentId;
        }
        return $this->datacontext->getObject($sql, $param);
    }

}
