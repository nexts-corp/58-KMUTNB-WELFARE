<?php

namespace apps\basics\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use apps\basics\interfaces\IStaffService;
use apps\common\entity\PositionsType;

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

    
 

    public function viewSearch($data) {
        $view = new CJView("position/type/list", CJViewType::HTML_VIEW_ENGINE);

        $sql="select pit from \\apps\\common\\entity\\PositionsType pit "
                . " where pit.positionsTypeNameTh LIKE :name ";
       
        $view->cuss = $this->datacontext->getObject($sql,array("name"=>"%".$data."%"));
//        print_r($view->cuss);
        return $view;
    }

    public function delete($id) {
         $deleteType = new PositionsType();
        $deleteType->setPositionsTypeId($Id);
        return $this->datacontext->removeObject($deleteType);
   
    }

}
