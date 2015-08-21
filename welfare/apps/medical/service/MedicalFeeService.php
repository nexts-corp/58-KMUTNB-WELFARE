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

    public function savemedical($data) {
        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function province() {

        $pv = new Province();
        $pv->setName('a');
        $pv_info = $this->datacontext->getObject($pv);
        if ($pv_info) {
            return $pv_info;
        }
        return NULL;
    }

    public function hospital() {
        $ht = new Hospital();
        $ht_info = $this->datacontext->getObject($ht);
        if ($ht_info) {
            return $ht_info;
        }
        return NULL;
    }

    public function searchUser($registerIdCard) {
        $user = new Register();
        $user->setRegisterIdCard($registerIdCard);
        // $user->setRegisterPosision()
        //$user_info = ;

        $datas = $this->datacontext->getObject($user);

        $path = '\\apps\\common\\entity\\';

        //$setting = new SettingMedicalFee();
        $sql = "SELECT s.amountSetting as amountSetting FROM " . $path . "SettingMedicalFee s order by s.SettingMedicalFeeId desc";
        $setObjAmount = $this->datacontext->getObject($sql);
        if ($datas) {
            $sql = "SELECT sum(m.amount) as aa FROM " . $path . "MedicalFee m WHERE m.registerId = '" . $datas[0]->registerId . "'";
            $getObjAmount = $this->datacontext->getObject($sql);

            $arr = array(
                'user' => $datas[0],
                'amount' => $setObjAmount[0]['amountSetting'] - $getObjAmount[0]['aa']//$getObjAmount
            );
            return $arr;
        }


        return NULL; //$this->datacontext->getObject($user);
    }

    public function save() {

        $path = '\\apps\\common\\entity\\';
        $sql = "SELECT r.registerId as userId FROM " . $path . "Register r WHERE r.registerIdCard = '" . $registerId->registerId . "'";
        $getObjAmount = $this->datacontext->getObject($sql);

        $daoMedicalFee = new MedicalFee();
        $daoMedicalFee->setRegisterId($getObjAmount[0]['userId']);
        $daoMedicalFee->setAmount($registerId->amount);
        $daoMedicalFee->setHospital($registerId->hospital);

        return $this->datacontext->saveObject($daoMedicalFee);
    }

    public function edit($data) {
        
    }

    public function delete($medicalFeeId) {
        $deleteMedicalFee = new MedicalFee();
        $deleteMedicalFee->setMedicalFeeId($medicalFeeId);
        //$delete = $this->datacontext->getObject($deleteTitleName)[0];
        return $this->datacontext->removeObject($deleteMedicalFee);
    }

    public function viewSearch($data) {
        $view = new CJView("medicalfee/list", CJViewType::HTML_VIEW_ENGINE);

        $sql = "select tin from \\apps\\common\\entity\\Register reg "
                . " where reg.registerNameTh LIKE :name or reg.registerLastNameTh LIKE :name";

        $view->member = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));
//        print_r($view->datas);
        return $view;
    }

}
