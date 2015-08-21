<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\member\interfaces\IFamilyService;
use apps\common\entity\Family;

class FamilyService extends CServiceBase implements IFamilyService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
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
        
          if ($this->datacontext->updateObject($data)) {
           $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

   
    public function delete($id) {
        $del = new Family();
        $del->setFamilyId($id);
        
        return $this->datacontext->removeObject($del);
    }

}
