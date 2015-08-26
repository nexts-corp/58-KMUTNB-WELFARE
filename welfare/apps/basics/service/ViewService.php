<?php

namespace apps\basics\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use \apps\basics\interfaces\IViewService;
use apps\basics\entity\Faculty;
use apps\basics\entity\AcademicType;
use apps\basics\entity\Department;
use apps\basics\entity\Positions;
use apps\basics\entity\Staff;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    // start serviec view academic

    public function academicAdd() {

        $view = new CJView("academic/add", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function academicEdit($id) {

        $view = new CJView("academic/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoAcademic = new AcademicType();
        $daoAcademic->setAcademicTypeId($id);
        $getObj = $this->datacontext->getObject($daoAcademic);
        $view->datas = $getObj;
        return $view;
    }

    public function academicLists() {

       $data = $this->getRequest()->SearchName;
     
        if (!empty($data)) {
            $view = new CJView("academic/lists", CJViewType::HTML_VIEW_ENGINE);
            $sql="select acd from \\apps\\basics\\entity\\AcademicType acd "
                ." where acd.academicTypeTh LIKE :name or acd.academicTypeEn LIKE :name or acd.abbreviationTh LIKE :name or acd.abbreviationEn LIKE :name";
       
            $view->datas = $this->datacontext->getObject($sql, array("name" =>"%".$data."%"));
            return $view;
        }else{
            $view = new CJView("academic/lists", CJViewType::HTML_VIEW_ENGINE);
            $daoAcademic = new AcademicType();
            $getObj = $this->datacontext->getObject($daoAcademic);
            $view->datas = $getObj;
            return $view;
        }
    }

    //end service view academic
    // start serviec view department

    public function departmentAdd($id) {

        $view = new CJView("department/add", CJViewType::HTML_VIEW_ENGINE);
        $view->faculty = $id;

        $daoFaculty = new Faculty;
        $getObj = $this->datacontext->getObject($daoFaculty);
        $view->datas = $getObj;

        return $view;
    }

    public function departmentEdit($id) {

        $view = new CJView("department/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoDepartment = new Department();
        $daoDepartment->setDepartmentId($id);
        $getObj = $this->datacontext->getObject($daoDepartment);
        $view->datas = $getObj;
        return $view;
    }

    public function departmentLists($id) {
        
        $data = $this->getRequest()->SearchName;
          
          if (!empty($data)) {
        $view = new CJView("department/lists", CJViewType::HTML_VIEW_ENGINE);
        $sql="select dep from \\apps\\basics\\entity\\Department dep "
                . " where dep.departmentNameTh LIKE :name or dep.departmentNameEn LIKE :name";           
           $view->datasDepart = $this->datacontext->getObject($sql, array("name" =>"%".$data."%"));
            return $view;
        }else{
            $view = new CJView("department/lists", CJViewType::HTML_VIEW_ENGINE);
            $daoDepartment = new Department;
            $daoDepartment->setFacultyId($id);
            $getObj = $this->datacontext->getObject($daoDepartment);
            $view->faculty = $id;
            $view->datasDepart = $getObj;
            return $view;
        }
    }

    // end serviec view department
    // start serviec view faculty

    public function facultyAdd() {

        $view = new CJView("faculty/add", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function facultyEdit($id) {

        $view = new CJView("faculty/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoFaculty = new Faculty;
        $daoFaculty->setFacultyId($id);
        $getObj = $this->datacontext->getObject($daoFaculty);
        $view->datas = $getObj;

        return $view;
    }

    public function facultyLists() {

          $data = $this->getRequest()->SearchName;
          
          if (!empty($data)) {
            $view = new CJView("faculty/lists", CJViewType::HTML_VIEW_ENGINE);
            $sql="select fac from \\apps\\basics\\entity\\Faculty fac "
                . " where fac.facultyNameTh LIKE :name or fac.facultyNameEn LIKE :name or fac.facultyCode LIKE :name";
           $view->datas = $this->datacontext->getObject($sql, array("name" =>"%".$data."%"));
            return $view;
        }else{
            $view = new CJView("faculty/lists", CJViewType::HTML_VIEW_ENGINE);
            $daoFaculty = new Faculty;
            $getObj = $this->datacontext->getObject($daoFaculty);
            $view->datas = $getObj;
        
        return $view;
        }
    }

    // end serviec view faculty
    // start serviec view positions

    public function positionsAdd() {

        $view = new CJView("positions/add", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function positionsEdit($id) {

        $view = new CJView("positions/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoPositions = new Positions();
        $daoPositions->setPositionsId($id);
        $getObj = $this->datacontext->getObject($daoPositions);
        $view->datas = $getObj;
        return $view;
    }

    public function positionsLists() {

         $data = $this->getRequest()->SearchName;

         if (!empty($data)) {
        $view = new CJView("positions/lists", CJViewType::HTML_VIEW_ENGINE);
            $sql="select ps from \\apps\\basics\\entity\\Positions ps "
                ." where ps.positionsNameTh LIKE :name or ps.positionsNameEn LIKE :name";
            $view->datas =$this->datacontext->getObject($sql,array("name"=>"%".$data."%"));
            return $view;
        }else{
        $view = new CJView("positions/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoPositions = new Positions();
        $getObj = $this->datacontext->getObject($daoPositions);
        $view->datas = $getObj;
        return $view;
        }
    }

    // end serviec view positions
    // start serviec view staff

    public function staffAdd() {
        $view = new CJView("staff/add", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function staffEdit($id) {

        $view = new CJView("staff/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoStaff = new Staff();
        $daoStaff->setStaffId($id);
        $getObj = $this->datacontext->getObject($daoStaff);
        $view->datas = $getObj;
        return $view;
    }

    public function staffLists() {

         $data = $this->getRequest()->SearchName;

         if (!empty($data)) {
            $view = new CJView("staff/lists", CJViewType::HTML_VIEW_ENGINE);
            $sql="select st from \\apps\\basics\\entity\\Staff st "
                ." where st.staffNameTh LIKE :name or st.staffNameEn LIKE :name";
            $view->datas =$this->datacontext->getObject($sql,array("name"=>"%".$data."%"));
            return $view;
        }else{
            $view = new CJView("staff/lists", CJViewType::HTML_VIEW_ENGINE);
            $daoStaff = new Staff();
            $getObj = $this->datacontext->getObject($daoStaff);
            $view->datas = $getObj;
            return $view;
        }
    }

    // end serviec view staff
    // start serviec view titleName


}
