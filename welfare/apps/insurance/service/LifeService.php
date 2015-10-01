<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\insurance\interfaces\ILifeService;
use apps\insurance\entity\Life;

class LifeService extends CServiceBase implements ILifeService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function lists() {
        $year = date("Y");
        $param = array(
            "protectYear" => $year
        );
        $and = "";
        if ($this->getRequest()->payment != "") {
            $and = " and inf.payment = :payment ";
            $param['payment'] = $this->getRequest()->payment;
        }

        $sql = "select fm.*,ifnull(fm.academic1,fm.titleName1) as titleName, "
                . "inf.lifeId, inf.payment,inf.received,inf.protectYear "
                . "from v_fullmember fm "
                . "join insurancelife inf "
                . "on inf.memberId = fm.memberId "
                . "where inf.protectYear = :protectYear " . $and;

        $datas = $this->datacontext->pdoQuery($sql, $param);
        $i = 1;
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $datas[$key]['rowNo'] = $i++;
                if ($value['payment'] == "yes") {
                    $datas[$key]['payment'] = "ชำระเงินแล้ว";
                } else {
                    $datas[$key]['payment'] = "ยังไม่ชำระเงิน";
                }
            }
        }

        return $datas;
    }

    public function update($life) {
        return $this->datacontext->updateObject($life);
    }

    public function saveBeneficiary($Benef) {
        if ($this->datacontext->saveObject($Benef)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return $Benef;
        }
    }

}
