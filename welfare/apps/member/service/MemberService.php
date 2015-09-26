<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;
use apps\member\interfaces\IMemberService;
use apps\user\entity\User;
use apps\member\entity\Member;
use apps\member\entity\Contact;
use apps\member\entity\Salary;
use apps\member\entity\Work;
use apps\member\entity\History;

class MemberService extends CServiceBase implements IMemberService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext("default");
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
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

    public function update($member) {
        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
//        $salary = $member->salary;
//        $contact = $member->contact;
//        $work = $member->work;
        if ($member->dob != "") {
            $dob1 = explode("-", $member->dob);
            $dob1[2] = intVal($dob1[2]) - 543;
            $dob = $dob1[2] . "-" . $dob1[1] . "-" . $dob1[0];
            $member->dob = new \DateTime($dob);
        }
        if ($member->workStartDate != "") {
            $date1 = explode("-", $member->workStartDate);
            $date1[2] = intVal($date1[2]) - 543;
            $workStartDate = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
            $member->workStartDate = new \DateTime($workStartDate);
        }
        if($member->document !=""){
            $document = $member->document;
            $doc = new \apps\member\entity\Document();
            $doc->memberId = $member->memberId;
            $doc->filename = $document;
            $doc->remark = $member->remark;
            $this->datacontext->saveObject($doc);
            
            
        }
        //$salary = $this->getRequest()->getValue(new Salary(),"data.salary");
        //$this->getRequest()->data2->data->salary;
        $json = new CJSONDecodeImpl();
        $salary = $json->decode(new Salary(), $this->getRequest()->data2->data, "salary");
        $contact = $json->decode(new Contact(), $this->getRequest()->data2->data, "contact");
        $work = $json->decode(new Work(), $this->getRequest()->data2->data, "work");

        if ($salary->salaryDate != "") {
            $date1 = explode("-", $salary->salaryDate);
            $date1[2] = intVal($date1[2]) - 543;
            $salayDate = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
            $salary->salaryDate = new \DateTime($salayDate);
        }

        unset($member->salary);
        unset($member->contact);
        unset($member->work);

        $salary->memberId = $member->memberId;
        $contact->memberId = $member->memberId;
        $work->memberId = $member->memberId;


        $s = new Salary();
        $s->memberId = $member->memberId;
        $salaryOld = $this->datacontext->getObject($s)[0];
        $salary->salaryId = $salaryOld->salaryId;
        
        $c = new Contact();
        $c->memberId = $member->memberId;
        $contactOld = $this->datacontext->getObject($c)[0]; //contact
        $contact->contactId = $contactOld->contactId;
        
        $w = new Work();
        $w->memberId = $member->memberId;
        $workOld = $this->datacontext->getObject($w)[0]; //work
        $work->workId = $workOld->workId;
        
        $m = new Member();
        $m->memberId = $member->memberId;
        $memberOld = $this->datacontext->getObject($m)[0]; //member


        $return = true;
        if ($this->saveHistory($member, $memberOld, "member")) {
            if ($this->saveHistory($work, $workOld, "work")) {
                if ($this->saveHistory($contact, $contactOld, "contact")) {
                    if ($this->saveHistory($salary, $salaryOld, "salary")) {
                        $return = true;
                    } else {
                        $this->getResponse()->add("message", $this->datacontext->getLastMessage());
                        $return = false;
                    }
                } else {
                    $this->getResponse()->add("message", $this->datacontext->getLastMessage());
                    $return = false;
                }
            } else {
                $this->getResponse()->add("message", $this->datacontext->getLastMessage());
                $return = false;
            }
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            $return = false;
        }
        return $return;


//        $current = new Member();
//        $current->memberId = $data->memberId;
//        $current = $this->datacontext->getObject($current)[0];
//        if ($data->userTypeId != "") {
//            $user = new User();
//            $user->memberId = $data->memberId;
//            $dataUser = $this->datacontext->getObject($user)[0];
////   print $data->userTypeId . " " . $dataUser->userTypeId;
////            print_r($dataUser->userTypeId);
////            exit();
//            if ($data->userTypeId != $dataUser->userTypeId) {
//// print "!=";
//                $history = new History();
//                $history->memberId = $data->memberId;
//                $history->fieldChange = "userTypeId";
//                $history->valueOld = $dataUser->userTypeId;
//                $history->valueNew = $data->userTypeId;
//
//                $this->datacontext->saveObject($history);
//
//                $dataUser->userTypeId = $data->userTypeId;
//                $this->datacontext->updateObject($dataUser);
//            }
//        }
//        $memberId = $data->memberId;
//
//        foreach ($data as $fieldNew => $valueNew) {
//            
//            if ($valueNew != null) {
//                foreach ($current as $filedOld => $valueOld) {
//                    if ($fieldNew == $filedOld) {
//                        if ($valueNew != $valueOld || $fieldNew != "memberId") {
//                            $history = new MemberHistory();
//                            $history->memberId = $data->memberId;
//                            $history->fieldChange = $filedOld;
//                            if (is_a($valueOld, "DateTime")) { //if value is DateTime
////                            if ($filedOld == "workStartDate" || $filedOld == "workEndDate" || $filedOld == "dob") {
//                                $history->valueOld = $valueOld->format('Y-m-d');
//                                $history->valueNew = $valueNew->format('Y-m-d');
//                                $this->datacontext->saveObject($history);
//                            } elseif ($filedOld != "userTypeId") {
//                                $history->valueOld = $valueOld;
//                                $history->valueNew = $valueNew;
//                                $this->datacontext->saveObject($history);
//                            }
//                        }
//                    }
//                }
//            }
//        }
//        if ($this->datacontext->updateObject($data)) {
//
//            $this->getResponse()->add("message", "อัพเดทข้อมูลสำเร็จ");
//            return true;
//        } else {
//            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
//            return false;
//        }
    }

    public function saveHistory($dataNew, $dataOld, $entity) {
        foreach ($dataNew as $fieldNew => $valueNew) {
            if ($valueNew != null) {
                foreach ($dataOld as $filedOld => $valueOld) {
                    if ($fieldNew == $filedOld && $fieldNew != "memberId") {
                        if ($valueNew != $valueOld) {
                            $history = new History();
                            $history->memberId = $dataNew->memberId;
                            $history->entityChange = $entity;
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
        return $this->datacontext->updateObject($dataNew);
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
                . "WHERE  ";

        if ($data->searchName != "") {
            $searchName = $data->searchName;
            $sql .= " mem1.fname LIKE :name or mem1.lname LIKE :name or mem1.idCard LIKE :name mem1.memberActive2 = 'Working'";
            $param = array(
                "name" => "%" . $searchName . "%"
            );
        } else if ($data->filterCode == "memberActive") {
            $filtercode = $data->filterCode;
            $filtervalue = $data->filtervalue;
            $sql .= "  mem1." . $filtercode . "Id = :filtervalue ";
            $param["filtervalue"] = $filtervalue;
        } else {
            $filtercode = $data->filterCode;
            $filtervalue = $data->filtervalue;
            $sql .= "  mem1." . $filtercode . "Id = :filtervalue and mem1.memberActive2 = 'Working' ";
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

    public function reference($file) {

        $uploaddir = './uploads/member/' . $this->getRequest()->memberId . "/";
//        $path = "apps/auction/files/" . $data[0]->properser_id;
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777);
        }
        $filename = 'mem' . date("YmdHis");
        $typefile = explode(".", $file["name"]);
        $filenames = $filename . "." . $typefile[count($typefile) - 1];
        $uploadfile = $uploaddir . $filenames;
//            print_r($uploadfile);
//            exit();

        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            return $filenames;
        } else {
            return FALSE;
        }
    }

    public function upload($file) {

        $return = true;
        $csv = fopen($file['tmp_name'], "r");
        $arr = array();
        while (!feof($csv)) {
            array_push($arr, fgetcsv($csv));
        }
        fclose($csv);
        array_splice($arr, 0, 1);
        array_pop($arr);

        $uploaddir = './uploads/member/';
        $filename = 'mem' . date("YmdHis") . ".csv";
        $uploadfile = $uploaddir . $filename;


        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            chmod($uploadfile, 0777);
            $error = array();

            foreach ($arr as $key => $value) {


                $idCard = str_replace(" ", "", $value[0]);
                $academic = str_replace(" ", "", $value[1]);
                $titleName = str_replace(" ", "", $value[2]);
                $fname = str_replace(" ", "", $value[3]);
                $lname = str_replace(" ", "", $value[4]);
                $gender = str_replace(" ", "", $value[5]);
                $employeeCode = str_replace(" ", "", $value[6]);
                $employeeType = str_replace(" ", "", $value[7]);
                $position = str_replace(" ", "", $value[8]);
                $rank = str_replace(" ", "", $value[9]);
                $faculty = str_replace(" ", "", $value[10]);
                $department = str_replace(" ", "", $value[11]);
                $matier = str_replace(" ", "", $value[12]);
                $workStartDate = str_replace(" ", "", $value[13]);
                $workStartDate = explode("/", $workStartDate);
                $workStartDate = new \DateTime(intval($workStartDate[2] - 543) . "-" . $workStartDate[1] . "-" . $workStartDate[0]);
                $salary = str_replace(" ", "", $value[14]);
                $salaryDate = str_replace(" ", "", $value[15]);
                $salaryDate = explode("/", $salaryDate);
                $salaryDate = new \DateTime(intval($salaryDate[2] - 543) . "-" . $salaryDate[1] . "-" . $salaryDate[0]);
                $address = $value[16];
                $internalPhone = str_replace(",", "", str_replace(" ", "", $value[17]));
                $phone = str_replace(" ", "", $value[18]);
                $mobile = str_replace(" ", "", $value[19]);
                $email = str_replace(" ", "", $value[20]);
                $dob = str_replace(" ", "", $value[21]);
                $dob = explode("/", $dob);
                $pwd = md5($dob[0].$dob[1].$dob[2]);
                $dob = new \DateTime(intval($dob[2] - 543) . "-" . $dob[1] . "-" . $dob[0]);
                $memberActiveId = str_replace(" ", "", $value[22]);
                
//                $dateNotice = explode("-", $dateNotice);
//                $dateNotice = new \DateTime(intval($dateNotice[2] - 543) . "-" . $dateNotice[1] . "-" . $dateNotice[0]);
//                $myBenefit = str_replace(",", "", str_replace(" ", "", $value[6]));
//                $employerBenefit = str_replace(",", "", str_replace(" ", "", $value[7]));
//                $grantInAid = str_replace(",", "", str_replace(" ", "", $value[8]));
//                $total = str_replace(",", "", str_replace(" ", "", $value[9]));
//                $member = new \apps\member\model\FullMember();
//                $member->idCard = $idCard;
//                $member->employeeTypeId = $employeeType->id;
//                $dataMember = $this->datacontext->getObject($member);
//                if (count($dataMember) == 0) {
//                    array_push($error, array(
//                        "idCard" => $idCard,
//                        "fname" => $fname,
//                        "lname" => $lname,
//                        "saving" => $saving,
//                        "myBenefit" => $myBenefit,
//                        "employerBenefit" => $employerBenefit,
//                        "grantInAid" => $grantInAid,
//                        "total" => $total,
//                        "dateNotice" => $value[3]
//                    ));
//                } else {}

                $member = new \apps\member\entity\Member();
                $member->idCard = $idCard;
                $member->titleNameId = $this->taxonomy->getPCodeValue("titleName", $titleName)[0]->id;
                if ($academic != "") {
                    $member->academicId = $this->taxonomy->getPCodeValue("academic", $academic)[0]->id;
                }
                $member->fname = $fname;
                $member->lname = $lname;
                $member->genderId = $this->taxonomy->getPCodeValue("gender", $gender)[0]->id;
                $member->dob = $dob;
                $member->employeeCode = $employeeCode;
                $member->workStartDate = $workStartDate;
                $member->memberActiveId = $this->taxonomy->getPCodeValue("memberActive", $memberActiveId)[0]->id;
//                    $employee->saving = $saving;
//                    $employee->myBenefit = $myBenefit;
//                    $employee->employerBenefit = $employerBenefit;
//                    $employee->grantInAid = $grantInAid;
//                    $employee->total = $total;
//                    $employee->dateNotice = $dateNotice;
//                    $employee->filename = $filename;

                if ($this->datacontext->saveObject($member)) {

//                    $memb = new \apps\member\entity\Member();
//                    $memb->setIdCard($idCard);
//                    $mem = $this->datacontext->getObject($memb);
                    $usertype = new \apps\taxonomy\entity\Taxonomy();
                    $usertype->code = "user";
                    $usertype->pCode = "userType";
                    $usert = $this->datacontext->getObject($usertype)[0];
                    
                    $user = new \apps\user\entity\User();
                    $user->memberId = $member->memberId;
                    $user->username = $idCard;
                    $user->userTypeId = $usert->id;
                    $user->password = $pwd;
                    $work = new \apps\member\entity\Work();
                    $work->memberId = $member->memberId;
                    $work->employeeTypeId = $this->taxonomy->getPCodeValue("employeeType", $employeeType)[0]->id;
                    $work->positionId = $this->taxonomy->getPCodeValue("position", $position)[0]->id;
                    $work->facultyId = $this->taxonomy->getPCodeValue("faculty", $faculty)[0]->id;
                    $departCode = $this->taxonomy->getPCodeValue("faculty", $faculty)[0]->code;
                    $depart = $this->taxonomy->getPCodeValue($departCode, $department);
                    foreach ($depart as $key2 => $value2) {
                        if ($value2->value1 == $department) {
                            $work->departmentId = $value2->id;
                        }
                    }
//                    print_r($depart);
//                    exit();
                    $work->matierId = $this->taxonomy->getPCodeValue("matier", $matier)[0]->id;
                    $sala = new \apps\member\entity\Salary();
                    $sala->memberId = $member->memberId;
                    $sala->salary = $salary;
                    $sala->salaryDate = $salaryDate;
                    $sala->rank = $rank;
                    $contact = new \apps\member\entity\Contact();
                    $contact->memberId = $member->memberId;
                    $contact->address = $address;
                    $contact->internalPhone = $internalPhone;
                    $contact->phone = $phone;
                    $contact->mobile = $mobile;
                    $contact->email = $email;
                    if ($this->datacontext->saveObject($user)) {
                        $return = true;
                    }
                    if ($this->datacontext->saveObject($work)) {
                        $return = true;
                    }
                    if ($this->datacontext->saveObject($sala)) {
                        $return = true;
                    }
                    if ($this->datacontext->saveObject($contact)) {
                        $return = true;
                    } else {
                        $return = "cantUpload";
                    }
                }
            }
            if (count($error) > 0) {
                $return = $error;
            }
        } else {
            $return = "cantUpload";
            //$return = $uploadfile;
        }

        return $return;
    }

}
