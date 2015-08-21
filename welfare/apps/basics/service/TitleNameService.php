<?php

namespace apps\basics\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\basics\interfaces\ITitleNameService;
use apps\common\entity\TitleName;

class TitleNameService extends CServiceBase implements ITitleNameService {

    public $datacontext;
    public $model = "apps\\common\\entity\\";

    function __construct() {
        $this->datacontext = new CDataContext("default");
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

    public function delete($titleNameId) {
        $daoTitleName = new TitleName();
        $daoTitleName->setTitleNameId($titleNameId);
        //$delete = $this->datacontext->getObject($daoTitleName)[0];
        return $this->datacontext->removeObject($daoTitleName);
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

//    public function viewSearch($data) {
//        $view = new CJView("titlename/list", CJViewType::HTML_VIEW_ENGINE);
//
//        $sql = "select tin from \\apps\\common\\entity\\TitleName tin "
//                . " where tin.titleNameTh LIKE :name or tin.titleNameEn LIKE :name";
//
//        $view->list = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));
//        return $view;
//    }

}
