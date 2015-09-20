<?php

namespace apps\medical\service;

use apps\common\entity\Hospital;
use apps\common\entity\MedicalFee;
use apps\common\entity\Province;
use apps\common\entity\Register;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\medical\interfaces\IMedicalFeeService;

class MedicalFeeService extends CServiceBase implements IMedicalFeeService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function medicallist($retireYear) {
        
    }

//    public function savemedical($data) {
//        if ($this->datacontext->saveObject($data)) {
//            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
//            return true;
//        } else {
//            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
//            return false;
//        }
//    }
//
//    public function province() {
//
//        $pv = new Province();
//        $pv->setName('a');
//        $pv_info = $this->datacontext->getObject($pv);
//        if ($pv_info) {
//            return $pv_info;
//        }
//        return NULL;
//    }
//
//    public function hospital() {
//        $ht = new Hospital();
//        $ht_info = $this->datacontext->getObject($ht);
//        if ($ht_info) {
//            return $ht_info;
//        }
//        return NULL;
//    }
//
    public function searchUser($idCard) {

        $searchName = $this->getRequest()->searchName;
        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->setCode("medical001");
        $query = $this->datacontext->getObject($welfare)[0];

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $query->welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];

        $dateStart = $dateBudget["startDate"];
        $dateEnd = $dateBudget["endDate"];

        $sql1 = "select mem.fname,mem.lname,wh.welfareId,wc.conditionsId,wh.memberId,weld.quantity,"
                . "sum(wh.amount) as payment,weld.quantity-sum(wh.amount) as balance, "
                . "IFNULL(academic.value1,title.value1) title "
                . "from welfarehistory wh "
                . "inner join welfare wel "
                . "on wel.welfareId = wh.welfareId and wel.code = 'medical001' "
                . "inner join welfareconditions wc "
                . "on wc.welfareId = wh.welfareId "
                . "inner join welfaredetails weld "
                . "on weld.welfareId = wc.welfareId "
                . "inner join v_member mem "
                . "on mem.memberId = wh.memberId and mem.idCard = :idCard and mem.employeeTypeId = weld.returnTypeId "
                . "Left JOIN taxonomy title "
                . "on mem.titleNameId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mem.academicId = academic.id "
                . "where wh.dateCreated between :dateStart and :dateEnd ";

        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd,
            "idCard" => $idCard
        );
        $budget = $this->datacontext->pdoQuery($sql1, $param)[0];
        if ($budget['memberId'] == "") {

            $sql2 = "select mb.memberId,mb.fname,mb.lname,wf.welfareId,wc.conditionsId,weld.quantity as balance "
                    . "from welfareconditions wc "
                    . "join welfaredetails weld "
                    . "on weld.welfareId = wc.welfareId "
                    . "join welfare wf on wf.code = 'medical001' and wc.welfareId = wf.welfareId "
                    . "join v_member mb on mb.idCard = :idCard and mb.employeeTypeId = weld.returnTypeId ";
            $param = array(
                "idCard" => $idCard
            );
            $budget = $this->datacontext->pdoQuery($sql2, $param)[0];

            return $budget;
        } else {

            return $budget;
        }
    }

    public function save($data) {
        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return $data;
        }
    }

    public function search($data) {

        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->setCode("medical001");
        $query = $this->datacontext->getObject($welfare)[0];

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $query->welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];

        $dateStart = $dateBudget["startDate"];
        $dateEnd = $dateBudget["endDate"];

        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd,
            "name" => "%" . $data . "%"
        );
        $sql = "select mem.fname,mem.lname,wh.welfareId,wc.conditionsId,wh.remark,wh.memberId,weld.quantity,"
                . "sum(wh.amount) as payment,weld.quantity-sum(wh.amount) as balance, "
                . "IFNULL(academic.value1,title.value1) title "
                . "from welfarehistory wh "
                . "inner join welfare wel "
                . "on wel.welfareId = wh.welfareId and wel.code = 'medical001' "
                . "inner join welfareconditions wc "
                . "on wc.conditionsId = wh.conditionsId "
                . "inner join welfaredetails weld "
                . "on weld.welfareId = wc.welfareId "
                . "inner join member mem "
                . "on mem.memberId = wh.memberId and wc.employeeTypeId = mem.employeeTypeId "
                . "Left JOIN taxonomy title "
                . "on mem.titleNameId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mem.academicId = academic.id "
                . "where wh.dateCreated between :dateStart and :dateEnd "
                . "and (mem.fname LIKE :name or mem.lname LIKE :name or mem.idCard LIKE :name) "
                . "group by wh.memberId ";
        return $this->datacontext->pdoQuery($sql, $param);
    }

    public function update($data) {
        if ($this->datacontext->updateObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return FALSE;
        }
    }

    public function searchDetail($data) {
        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->setCode("medical001");
        $query = $this->datacontext->getObject($welfare)[0];

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $query->welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];

        $dateStart = $dateBudget["startDate"];
        $dateEnd = $dateBudget["endDate"];

        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd,
            "name" => "%" . $data . "%"
        );
        $sql = "select mem.fname,mem.lname,wh.welfareId,wc.conditionsId,wh.remark,wh.memberId,weld.quantity,"
                . "sum(wh.amount) as payment,weld.quantity-sum(wh.amount) as balance, "
                . "IFNULL(academic.value1,title.value1) title "
                . "from welfarehistory wh "
                . "inner join welfare wel "
                . "on wel.welfareId = wh.welfareId and wel.code = 'medical001' "
                . "inner join welfareconditions wc "
                . "on wc.conditionsId = wh.conditionsId "
                . "inner join welfaredetails weld "
                . "on weld.welfareId = wc.welfareId "
                . "inner join member mem "
                . "on mem.memberId = wh.memberId and wc.employeeTypeId = mem.employeeTypeId "
                . "Left JOIN taxonomy title "
                . "on mem.titleNameId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mem.academicId = academic.id "
                . "where wh.dateCreated between :dateStart and :dateEnd "
                . "and (mem.fname LIKE :name or mem.lname LIKE :name or mem.idCard LIKE :name) "
                . "group by wh.memberId ";
        return $this->datacontext->pdoQuery($sql, $param);
    }

    public function delete($historyId) {
        if ($historyId != "") {
            $history = new \apps\welfare\entity\History();
            $history->setHistoryId($historyId);
            $this->datacontext->removeObject($history);
            $this->getResponse()->add("message", "ลบข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return FALSE;
        }
    }

//
//    public function edit($data) {
//        
//    }
//
//    public function delete($medicalFeeId) {
//        $deleteMedicalFee = new MedicalFee();
//        $deleteMedicalFee->setMedicalFeeId($medicalFeeId);
//        //$delete = $this->datacontext->getObject($deleteTitleName)[0];
//        return $this->datacontext->removeObject($deleteMedicalFee);
//    }
//
//    public function viewSearch($data) {
//        $view = new CJView("medicalfee/list", CJViewType::HTML_VIEW_ENGINE);
//
//        $sql = "select tin from \\apps\\common\\entity\\Register reg "
//                . " where reg.registerNameTh LIKE :name or reg.registerLastNameTh LIKE :name";
//
//        $view->member = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));
////        print_r($view->datas);
//        return $view;
//    }
}
