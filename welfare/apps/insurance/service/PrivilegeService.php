<?php
namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\insurance\interfaces\IPrivilegeService;
use apps\common\entity\Privilege;

class PrivilegeService extends CServiceBase implements IPrivilegeService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    

    public function save($data) {
        // print_r($data);
        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return $data;
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


    public function viewSearch($data) {
        $view = new CJView("privilege/lists", CJViewType::HTML_VIEW_ENGINE);
        $path = '\\apps\\common\\entity\\';
        

        $sql="SELECT aca.academicPositionsNameTh,ra.rankNameTh,tit.titleNameTh,reg.registerId, reg.registerNameTh,reg.registerLastNameTh,de.departmentNameTh "
                . "FROM ".$path."Register reg "
                . "LEFT JOIN ".$path."AcademicPositions aca with "
                . "reg.academicPositionsId = aca.academicPositionsId "
                . "LEFT JOIN " . $path . "Rank ra with reg.rankId = ra.rankId "
                . "LEFT JOIN ".$path."Titlename tit with tit.titleNameId = reg.titleNameId "
                . "LEFT join  ". $path."department de with de.departmentId = reg.departmentId"
                . " where reg.registerNameTh LIKE :name or reg.registerLastNameTh LIKE :name ";
       
        $view->member = $this->datacontext->getObject($sql,array("name"=>"%".$data."%"));
//        print_r($view->datas);
        return $view;
    }

}
