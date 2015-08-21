<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\user\interfaces\ITypeService;
use apps\common\entity\UserType;

class TypeService extends CServiceBase implements ITypeService {

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

    public function delete($id) {

        $deleteUserType = new UserType();
        $deleteUserType->setUserTypeId($id);
        //$delete = $this->datacontext->getObject($deleteTitleName)[0];
        return $this->datacontext->removeObject($deleteUserType);
    }

}
