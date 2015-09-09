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
                $data[$key]->workStartDate = new \DateTime($data[$key]->workStartDate);
            }
            if ($data[$key]->workEndDate != "") {
                $data[$key]->workEndDate = new \DateTime($data[$key]->workEndDate);
            }
        }
        $this->datacontext->saveObject($data);
        
        foreach ($data as $key => $value) {
            $query = "select mb.memberId from Member mb "
                    . "where ";
            $where = "";
            foreach ($value as $key2 => $value2) {
                if ($value2 != null) {
                    if ($where != "") {
                        $where .= " and ";
                    }
                    switch ($key2) {
                        case "workStartDate":
                            $where .= " mb.workStartDate >= :" . $key2 . " ";
                            $param[$key2] = $value2->format('Y-m-d');
                            break;
                        case "workEndDate":
                            $where .= " mb.workEndDate <= :" . $key2 . " ";
                            $param[$key2] = $value2->format('Y-m-d');
                            break;
                        case "ageStart":
                            $where .= " TIMESTAMPDIFF(YEAR, mb.dob, CURDATE()) >= :" . $key2 . " ";
                               // . "CURRENT_DATE()-mb.dob >= :" . $key2 . " ";
                            $param[$key2] = $value2;
                            break;
                        case "ageEnd":
                            $where .= " TIMESTAMPDIFF(YEAR, mb.dob, CURDATE()) <= :" . $key2 . " ";
                            $param[$key2] = $value2;
                            break;
                        case "ageWorkStart":
                             $where .= " TIMESTAMPDIFF(YEAR, mb.workStartDate, CURDATE()) >= :" . $key2 . " ";
                            $param[$key2] = $value2;
                            break;
                        case "ageWorkEnd":
                            $where .= " TIMESTAMPDIFF(YEAR, mb.workStartDate, CURDATE()) <= :" . $key2 . " ";
                            $param[$key2] = $value2;
                            break;
                        case "genderId":
                            $where .= " mb.genderId = :" . $key2 . " ";
                            $param[$key2] = $value2;
                            break;
                        case "employeeTypeId":
                            $where .= " mb.employeeTypeId = :" . $key2 . " ";
                            $param[$key2] = $value2;
                            break;
                    }
                    
                }
            }
            $sql = $query . $where;
            $conId = $value->conditionsId;
            $member = $this->datacontext->pdoQuery($sql, $param);
            foreach($member as $memberKey => $memberValue){
                $right = new Right();
                $right->conditionsId = $conId;
                $right->memberId = $memberValue["memberId"];
                $this->datacontext->saveObject($right);
            }
        }
        return true;

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

    public function test() {
        $sql = " select m from \\apps\\member\\entity\\Member m "
                . "where m.workStartDate >= :workStartDate ";
        $param = array(
                //  "workStartDate"=>'2015-08-25',
                // "workStartDate1"=>'2015-08-25'
        );
        $param["workStartDate"] = '2015-08-25';
        return $this->datacontext->getObject($sql, $param);
        //return $param;
    }

}
