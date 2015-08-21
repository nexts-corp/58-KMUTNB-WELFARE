<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\member\interfaces\IMemberService;
use apps\common\entity\Register;

class MemberService extends CServiceBase implements IMemberService {

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

    public function viewList() {
        $view = new CJView("register/management/list", CJViewType::HTML_VIEW_ENGINE);
       $path = '\\apps\\common\\entity\\';
        $sql = "SELECT aca.academicPositionsNameTh,ra.rankNameTh,tit.titleNameTh,reg.registerId, reg.registerNameTh,reg.registerLastNameTh,de.departmentNameTh, reg.registerIdCard "
                . "FROM ".$path."Register reg "
                . "LEFT JOIN ".$path."AcademicPositions aca with "
                . "reg.academicPositionsId = aca.academicPositionsId "
                . "LEFT JOIN ".$path."Rank ra with reg.rankId = ra.rankId "
                . "LEFT JOIN ".$path."Titlename tit with tit.titleNameId = reg.titleNameId "
                . "LEFT JOIN  ".$path."department de with de.departmentId = reg.departmentId "
                . "ORDER BY reg.registerId DESC";
        print_r($sql);
        $listreg = $this->datacontext->getObject($sql);
        $view->list = $listreg;
        return $view;
    }
    
     public function viewAdd() {
        $view = new CJView("register/management/add", CJViewType::HTML_VIEW_ENGINE);
        $view->academicPositions = $this->datacontext->getObject(new \apps\common\entity\AcademicPositions());
        $view->rank = $this->datacontext->getObject(new \apps\common\entity\Rank());
        $view->titleName = $this->datacontext->getObject(new \apps\common\entity\TitleName());
        $view->positionsType = $this->datacontext->getObject(new \apps\common\entity\PositionsType());
        $view->positionsWork = $this->datacontext->getObject(new \apps\common\entity\PositionsWork());
        $view->faculty = $this->datacontext->getObject(new \apps\common\entity\Faculty());
        $view->department = $this->datacontext->getObject(new \apps\common\entity\Department());
        return $view;
    }

      public function viewEdit($id) {
          
        $view = new CJView("register/management/edit", CJViewType::HTML_VIEW_ENGINE);
        $view->academicPositions = $this->datacontext->getObject(new \apps\common\entity\AcademicPositions());
        $view->rank = $this->datacontext->getObject(new \apps\common\entity\Rank());
        $view->titleName = $this->datacontext->getObject(new \apps\common\entity\TitleName());
        $view->positionsType = $this->datacontext->getObject(new \apps\common\entity\PositionsType());
        $view->positionsWork = $this->datacontext->getObject(new \apps\common\entity\PositionsWork());
        $view->faculty = $this->datacontext->getObject(new \apps\common\entity\Faculty());
        $view->department = $this->datacontext->getObject(new \apps\common\entity\Department());
        
        $filter = new Register();
        $filter->setRegisterId($id);
        $dao_register = $this->datacontext->getObject($filter);
        $view->data = $dao_register;
        return $view;
    }

    public function viewListfamily() {
        $view = new CJView("family/management/list", CJViewType::HTML_VIEW_ENGINE);
//        $listregister = new Register();
//        $listreg = $this->datacontext->getObject($listregister);
//        $view->list = $listreg;
        return $view;
    }

    public function viewAddfamily() {
        $view = new CJView("family/management/add", CJViewType::HTML_VIEW_ENGINE);
//        $listregister = new Register();
//        $listreg = $this->datacontext->getObject($listregister);
//        $view->list = $listreg;
        return $view;
    }

    public function viewSearch($data) {
        $view = new CJView("member/management/lists", CJViewType::HTML_VIEW_ENGINE);

        $sql="select reg from \\apps\\common\\entity\\Register reg "
                . " where reg.registerNameTh LIKE :name or reg.registerLastNameTh LIKE :name or reg.registerNameEn LIKE :name or reg.registerLastNameEn LIKE :name";
       
        $view->list = $this->datacontext->getObject($sql,array("name"=>"%".$data."%"));
//        print_r($view->datas);
        return $view;
    }

}
