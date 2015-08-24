<?php

namespace apps\basics\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\basics\interfaces\IAcademicService;
use apps\common\entity\AcademicType;

class AcademicService extends CServiceBase implements IAcademicService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($data) {

        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function update($data) {

        if ($this->datacontext->updateObject($data)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function delete($data) {
              
            $daoAcademic = new AcademicType();
            $daoAcademic->setAcademicTypeId($data);     
             if($this->datacontext->removeObject($daoAcademic)){
                return true;
                }else{
                return false;
                }
       
    }

}
