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
        $salary = $data->salary;
        $contact = $data->contact;
        $work = $data->work;
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

        $salarydate = explode("-", $salary->salaryDate);
        $salarydate[2] = intVal($salarydate[2]) - 543;
        $salarydate = $salarydate[2] . "-" . $salarydate[1] . "-" . $salarydate[0];

        $data->dob = new \DateTime($dob);

        $data->workStartDate = new \DateTime($workStartDate);

        $salary->salaryDate = new \DateTime($salarydate);
        if ($this->datacontext->saveObject($data)) {

            $memberId = $data->memberId;
            $s = new \apps\member\entity\Salary();
            $s->memberId = $memberId;
            foreach ($salary as $key => $value) {
                $s->$key = $value;
            }
            $p = new \apps\member\entity\Work();
            $p->memberId = $memberId;
            foreach ($work as $key => $value) {
                $p->$key = $value;
            }
            $c = new \apps\member\entity\Contact();
            $c->memberId = $memberId;
            foreach ($contact as $key => $value) {
                $c->$key = $value;
            }
            $this->datacontext->saveObject($s);
            $this->datacontext->saveObject($p);
            $this->datacontext->saveObject($c);

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
        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
        $salary = $data->salary;
        $contact = $data->contact;
        $work = $data->work;
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

                $dataUser->userTypeId = $data->userTypeId;
                $this->datacontext->updateObject($dataUser);
            }
        }
        $memberId = $data->memberId;
        if ($usertype == "user") {
            if ($salary != "") {
                $s = new \apps\member\entity\Salary();
                $s->memberId = $memberId;
                if ($salary->salaryDate != "") {
                    $date1 = explode("-", $salary->salaryDate);
                    $date1[2] = intVal($date1[2]) - 543;
                    $salaryDate = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
                    $salary->salaryDate = new \DateTime($salaryDate);
                }
                foreach ($salary as $key => $value) {

                    $s->$key = $value;
                }
                unset($data->salary);
            } elseif ($work != "") {
                $p = new \apps\member\entity\Work();
                $p->memberId = $memberId;
                foreach ($work as $key => $value) {
                    $p->$key = $value;
                }
                unset($data->work);
            } elseif ($contact != "") {
                $c = new \apps\member\entity\Contact();
                $c->memberId = $memberId;
                foreach ($contact as $key => $value) {
                    $c->$key = $value;
                }
                unset($data->contact);
            }

            foreach ($data as $fieldNew => $valueNew) {
                if ($valueNew != null) {
                    foreach ($current as $filedOld => $valueOld) {
                        if ($fieldNew == $filedOld) {
                            if ($valueNew != $valueOld || $fieldNew != "memberId") {
                                $history = new MemberHistory();
                                $history->memberId = $data->memberId;
                                $history->fieldChange = $filedOld;
                                if (is_a($valueNew, "DateTime")) { //if value is DateTime
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

                if ($salary != "") {
                    $this->datacontext->saveObject($s);
                } elseif ($work != "") {
                    $this->datacontext->saveObject($p);
                } elseif ($contact != "") {
                    $this->datacontext->saveObject($c);
                }
                $this->getResponse()->add("message", "อัพเดทข้อมูลสำเร็จ");
                return true;
            } else {
                $this->getResponse()->add("message", $this->datacontext->getLastMessage());
                return false;
            }
        } else {
            $s = new \apps\member\entity\Salary();
            $s->memberId = $memberId;
            if ($salary->salaryDate != "") {
                $date1 = explode("-", $salary->salaryDate);
                $date1[2] = intVal($date1[2]) - 543;
                $salaryDate = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
                $salary->salaryDate = new \DateTime($salaryDate);
            }
            foreach ($salary as $key => $value) {

                $s->$key = $value;
            }
            $p = new \apps\member\entity\Work();
            $p->memberId = $memberId;
            foreach ($work as $key => $value) {
                $p->$key = $value;
            }
            $c = new \apps\member\entity\Contact();
            $c->memberId = $memberId;
            foreach ($contact as $key => $value) {
                $c->$key = $value;
            }
            unset($data->work);
            unset($data->salary);
            unset($data->contact);
            foreach ($data as $fieldNew => $valueNew) {
                if ($valueNew != null) {
                    foreach ($current as $filedOld => $valueOld) {
                        if ($fieldNew == $filedOld) {
                            if ($valueNew != $valueOld || $fieldNew != "memberId") {
                                $history = new MemberHistory();
                                $history->memberId = $data->memberId;
                                $history->fieldChange = $filedOld;
                                if (is_a($valueNew, "DateTime")) { //if value is DateTime
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


                $this->datacontext->saveObject($s);
                $this->datacontext->saveObject($p);
                $this->datacontext->saveObject($c);

                $this->getResponse()->add("message", "อัพเดทข้อมูลสำเร็จ");
                return true;
            } else {
                $this->getResponse()->add("message", $this->datacontext->getLastMessage());
                return false;
            }
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

        $sql = "select *,IFNULL(mem1.academic1,mem1.titleName1) title "
                . "FROM v_fullmember mem1 "
                . "WHERE mem1.memberActive2 = 'Working' ";

        if ($data->searchName != "") {
            $searchName = $data->searchName;
            $sql .= "and mem1.fname LIKE :name or mem1.lname LIKE :name or mem1.idCard LIKE :name ";
            $param = array(
                "name" => "%" .$searchName. "%"
            );
            
        } else{
          $filtercode = $data->filterCode ; 
          $filtervalue = $data->filtervalue;
          $sql .= " and mem1.".$filtercode."Id = :filtervalue ";
            $param["filtervalue"] = $filtervalue;  
        }  
        if ($usertype == "administrator") {
            
        } elseif ($usertype == "adminFaculty") {
            $sql .= " and mem1.facultyId = :facultyId ";
            $param["facultyId"] = $facultyId;
        } elseif ($usertype == "adminDepartment") {
            $sql .= " and mem1.departmentId = :departmentId ";
            $param["departmentId"] = $departmentId;
        }

        return $this->datacontext->pdoQuery($sql, $param);
    }

    public function find($field, $value) {
        $member = new \apps\member\model\FullMember();
        $member->$field = $value;
        return $this->datacontext->getObject($member);
    }

}
