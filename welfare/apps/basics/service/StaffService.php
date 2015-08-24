<?php

namespace apps\basics\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use apps\basics\interfaces\IStaffService;
use apps\basics\entity\Staff;

class StaffService extends CServiceBase implements IStaffService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($data) {
     
     
        if($this->datacontext->saveObject($data)){
              $this->getResponse()->add("message","บันทึกข้อมูลสำเร็จ");
            return true;
        }
        else{
            $this->getResponse()->add("message",$this->datacontext->getLastMessage());
            return false;
        }
    }

    public function update($data) {
        if($this->datacontext->updateObject($data)){
            return true;
        }
        else{
            $this->getResponse()->add("message",$this->datacontext->getLastMessage());
            return false;
        }
    }

 
    public function delete($Id) {
         $daoStaff = new Staff();
        $daoStaff->setStaffId($Id);
        
        if($this->datacontext->removeObject($daoStaff)){
        return true;
        }else{
        return false;
        }
   
    }

}
