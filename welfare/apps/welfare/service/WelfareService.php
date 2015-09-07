<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IWelfareService;

use apps\welfare\entity\Welfare;

class WelfareService extends CServiceBase implements IWelfareService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($data) {
        $data->dateStart = new \DateTime($data->dateStart);
        $data->dateEnd = new \DateTime($data->dateEnd);
        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function update($data) {
        
        $data->dateStart = new \DateTime($data->dateStart);
        $data->dateEnd = new \DateTime($data->dateEnd);
        
       
        
        if ($this->datacontext->updateObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function delete($id) {
        $daoWelfare = new Welfare();
        $daoWelfare->setWelfareId($id);
        
        if ($this->datacontext->removeObject($daoWelfare)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

  

//put your code here
}
