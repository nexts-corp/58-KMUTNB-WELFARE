<?php
namespace apps\basics\service;

use apps\basics\entity\Department;
use apps\basics\interfaces\IDepartmentService;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\core\CServiceBase;


    class DepartmentService extends CServiceBase implements IDepartmentService{
    
     
    public $datacontext;
            
    function __construct() {
        $this->datacontext = new CDataContext();
    }//กำหนดฐานข้อมูล
    
    
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
           $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function delete($id) {
        $daoDepartment = new Department();
        $daoDepartment->setDepartmentId($id);
        
        if($this->datacontext->removeObject($daoDepartment)){
        return true;
        }else{
        return false;
        }
    }

    

}
