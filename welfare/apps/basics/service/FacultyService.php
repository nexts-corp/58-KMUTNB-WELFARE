<?php

namespace apps\basics\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView; 
use th\co\bpg\cde\collection\CJViewType;
use apps\common\entity\Faculty;
use apps\basics\interfaces\IFacultyService;

class FacultyService extends CServiceBase implements IFacultyService {

     
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

    public function update($data) {
         if ($this->datacontext->updateObject($data)) {
           
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function delete($id) {
        $daoFaculty = new Faculty();
        $daoFaculty->setFacultyId($id);
        return $this->datacontext->removeObject($daoFaculty);
    }

//    public function viewSearch($data) {
//        $view = new CJView("faculty/list", CJViewType::HTML_VIEW_ENGINE);
//
//        $sql="select fac from \\apps\\common\\entity\\Faculty fac "
//                . " where fac.facultyNameTh LIKE :name or fac.facultyNameEn LIKE :name or fac.facultyCode LIKE :name";
//       
//        $view->list = $this->datacontext->getObject($sql,array("name"=>"%".$data."%"));
//        //print_r($view->datas);
//        return $view;
//    }

}
