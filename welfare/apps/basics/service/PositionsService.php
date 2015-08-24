<?php

namespace apps\basics\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\basics\interfaces\IPositionsService;
use apps\common\entity\Positions;

class PositionsService extends CServiceBase implements IPositionsService {

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

    public function delete($Id) {

        $daoPositions = new Positions();
        $daoPositions->setPositionsId($Id);
        
        if($this->datacontext->removeObject($daoPositions)){
        return true;
        }else{
        return false;
        }
    }

   

}
