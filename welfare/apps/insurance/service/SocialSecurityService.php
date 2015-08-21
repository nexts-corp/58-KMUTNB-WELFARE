<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\insurance\interfaces\ISocialSecurityService;

class SocialSecurityService extends CServiceBase implements ISocialSecurityService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function viewList() {
        $view = new CJView("socialSecurity/list", CJViewType::HTML_VIEW_ENGINE);
//        $filter = new AcademicPositions();
//        $dao_department = $this->datacontext->getObject($filter);
//        $view->cuss = $dao_department;
        return $view;
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
            $this->getResponse()->add("message", "อัพเดทข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function delete($data) {
        if ($this->datacontext->removeObject($data)) {
            $this->getResponse()->add("message", "ลบข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

//put your code here
}
