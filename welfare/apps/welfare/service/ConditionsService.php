<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IConditionsService;
use apps\welfare\entity\Conditions;
use apps\welfare\entity\Right;

class ConditionsService extends CServiceBase implements IConditionsService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function delete($id) {

        $daoConditions = new Conditions();
        $daoConditions->setConditionsId($id);

        if ($this->datacontext->removeObject($daoConditions)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function save($data) {


        foreach ($data as $key => $value) {
            if ($data[$key]->workStartDate != "") {

                $workStartDate1 = explode("-", $data[$key]->workStartDate);
                $workStartDate1[2] = intVal($workStartDate1[2]) - 543;
                $workStartDate = $workStartDate1[2] . "-" . $workStartDate1[1] . "-" . $workStartDate1[0];

                $data[$key]->workStartDate = new \DateTime($workStartDate);
            }
            if ($data[$key]->workEndDate != "") {

                $workEndDate1 = explode("-", $data[$key]->workEndDate);
                $workEndDate1[2] = intVal($workEndDate1[2]) - 543;
                $workStartDate = $workEndDate1[2] . "-" . $workEndDate1[1] . "-" . $workEndDate1[0];

                $data[$key]->workEndDate = new \DateTime($workStartDate);
            }
        }
        return $this->datacontext->saveObject($data);

//        foreach ($data as $key => $value) {
//            $query = "select mb.memberId from Member mb "
//                    . "where ";
//            $where = "";
//            foreach ($value as $key2 => $value2) {
//                if ($value2 != null) {
//                    if ($where != "") {
//                        $where .= " and ";
//                    }
//                    switch ($key2) {
//                        case "workStartDate":
//                            $where .= " mb.workStartDate >= :" . $key2 . " ";
//                            $param[$key2] = $value2->format('Y-m-d');
//                            break;
//                        case "workEndDate":
//                            $where .= " mb.workEndDate <= :" . $key2 . " ";
//                            $param[$key2] = $value2->format('Y-m-d');
//                            break;
//                        case "ageStart":
//                            $where .= " TIMESTAMPDIFF(YEAR, mb.dob, CURDATE()) >= :" . $key2 . " ";
//                            // . "CURRENT_DATE()-mb.dob >= :" . $key2 . " ";
//                            $param[$key2] = $value2;
//                            break;
//                        case "ageEnd":
//                            $where .= " TIMESTAMPDIFF(YEAR, mb.dob, CURDATE()) <= :" . $key2 . " ";
//                            $param[$key2] = $value2;
//                            break;
//                        case "ageWorkStart":
//                            $where .= " TIMESTAMPDIFF(YEAR, mb.workStartDate, CURDATE()) >= :" . $key2 . " ";
//                            $param[$key2] = $value2;
//                            break;
//                        case "ageWorkEnd":
//                            $where .= " TIMESTAMPDIFF(YEAR, mb.workStartDate, CURDATE()) <= :" . $key2 . " ";
//                            $param[$key2] = $value2;
//                            break;
//                        case "genderId":
//                            $where .= " mb.genderId = :" . $key2 . " ";
//                            $param[$key2] = $value2;
//                            break;
//                        case "employeeTypeId":
//                            $where .= " mb.employeeTypeId = :" . $key2 . " ";
//                            $param[$key2] = $value2;
//                            break;
//                    }
//                }
//            }
//            $sql = $query . $where;
//            $conId = $value->conditionsId;
//            $welfare = new \apps\welfare\entity\Welfare();
//            $welfare->welfareId = $value->welfareId;
//            $dataWelfare = $this->datacontext->getObject($welfare)[0];
//            if ($dataWelfare->willing != "Y") {
//                $member = $this->datacontext->pdoQuery($sql, $param);
//                foreach ($member as $memberKey => $memberValue) {
//                    $right = new Right();
//                    $right->conditionsId = $conId;
//                    $right->memberId = $memberValue["memberId"];
//                    $this->datacontext->saveObject($right);
//                }
//            }
//        }
    }

    public function update($data) {

        foreach ($data as $key => $value) {
            if ($data[$key]->workStartDate != "") {
                $data[$key]->workStartDate = new \DateTime($data[$key]->workStartDate);
            }
            if ($data[$key]->workEndDate != "") {
                $data[$key]->workEndDate = new \DateTime($data[$key]->workEndDate);
            }
        }

        return $this->datacontext->updateObject($data);
    }

    public function saveRight($data) {


        $memberId = $data->memberId;
        $conditionsId = $data->conditionsId;

        $checkRight = "SELECT ri.conditionId,ri.memberId, "
                . "FROM welfareright ri "
                . "where ri.memberId = " . $memberId . " and ri.conditionsId=" . $conditionsId . "";

        $daoRight = $this->datacontext->pdoQuery($checkRight);

        if ($daoRight == true) {
            $this->datacontext->saveObject($data);
            return true;
        } else {
            return false;
        }
    }

    public function preview($conditions) {
        $query = "SELECT *,IFNULL(academic1,titleName1) title "
                . "FROM v_fullmember "
                . "where ";

//        $query = "SELECT mb.memberId,mb.fname,mb.lname,mb.titleNameId,mb.genderId As genderId,mb.dob As dob,mb.workStartDate As workStartDate, mb.workEndDate As workEndDate , "
//                
//                . "IFNULL(academic.value1,title.value1) title, " //IFNULL(value1,value2) select ถ้ามีค่าใดค่าหนึ่ง ,ถ้ามีค่าทั้งคู่จะ select value1 ออกมา 
//                . "(employeeType.value1) As employeeType, "
//                . "(gender.value1) As gender, "
//                . "(faculty.value1) As faculty, "
//                . "(department.value1) As department,"
//                . "(mbw.employeeTypeId) As employeeTypeId ,"
//                . "(mbw.departmentId) As departmentId , "
//                . "(mbw.facultyId) As facultyId ,"
//                . "(mbw.positionId) As positionId "
//                . "FROM member mb "
//                . "Left JOIN memberwork mbw  "
//                . "on mb.memberId = mbw.memberId "
//                . "Left JOIN taxonomy title "
//                . "on mb.titleNameId = title.id "
//                . "Left JOIN taxonomy academic "
//                . "on mb.academicId = academic.id "
//                . "Left JOIN taxonomy employeeType "
//                . "on mbw.employeeTypeId = employeeType.id "
//                . "Left JOIN taxonomy gender "
//                . "on mb.genderId = gender.id "
//                . "Left JOIN taxonomy faculty "
//                . "on mbw.facultyId = faculty.id "
//                . "Left JOIN taxonomy department "
//                . "on mbw.departmentId = department.id "
//                . "where ";




        $field = array();
        foreach ($conditions as $key => $value) {
            $index = 0;
            if (!empty($field[$value->fieldMap])) {
                $index = count($field[$value->fieldMap]);
            }
            $field[$value->fieldMap][$index]['operations'] = $value->operations;
            $field[$value->fieldMap][$index]['valuex'] = $value->valuex;
        }
        $where = "";
        foreach ($field as $key => $value) {
            $count = count($value);
            $sql = "";
            if ($where != "") {
                $sql .= " AND ";
            }
            if ($count > 1 && $key == 0) {
                $sql .= " ( ";
            }
            foreach ($value as $key2 => $value2) {
                if ($sql != "" && $key2 > 0) {
                    if ($value2['operations'] == "=" || $value2['operations'] == "!=") {
                        $sql .= " OR ";
                    } else {
                        $sql .= " AND ";
                    }
                }
                if (strpos($value2['valuex'], "-") && ($key == "dob" || $key == "workStartDate" || $key == "workEndDate")) {
                    $sql .= " " . $key . " " . $value2['operations'] . " " . $value2['valuex'] . " ";
                } elseif (!strpos($value2['valuex'], "-") && ($key == "dob" || $key == "workStartDate" || $key == "workEndDate")) {
                    $sql .= " TIMESTAMPDIFF(YEAR," . $key . ", CURDATE()) " . $value2['operations'] . " " . $value2['valuex'] . " ";
                } else {
                    $sql .= " " . $key . " " . $value2['operations'] . " " . $value2['valuex'] . " ";
                }
            }
            if ($count > 1) {
                $sql .= " ) ";
            }
            $where .= $sql;
        }

        $sql = $query . $where;

           print_r($sql);
           exit();

        $member = $this->datacontext->pdoQuery($sql);


        return $member;
    }

}
