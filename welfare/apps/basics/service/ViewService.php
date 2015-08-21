<?php

namespace apps\basics\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\basics\interfaces\IViewService;
use apps\common\entity\Faculty;

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
        $view->data = $getObj;
        return $view;
    }

    public function academicLists() {

        $view = new CJView("academic/lists", CJViewType::HTML_VIEW_ENGINE);
//        $daoAcademic = new AcademicType();
//        $getObj = $this->datacontext->getObject($daoAcademic);
//        $view->datas = $getObj;
        return $view;
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
        $view->department = $getObj;
        return $view;
    }

    public function departmentLists($id) {

        $view = new CJView("department/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoDepartment = new Department;
        $daoDepartment->setFacultyId($id);
        $getObj = $this->datacontext->getObject($daoDepartment);
        $view->faculty = $id;
        $view->depart = $getObj;

        return $view;
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

        $view = new CJView("faculty/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoFaculty = new Faculty;
        $getObj = $this->datacontext->getObject($daoFaculty);
        $view->datas = $getObj;

        return $view;
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

        $view = new CJView("positions/lists", CJViewType::HTML_VIEW_ENGINE);
//        $daoPositions = new Positions();
//        $getObj = $this->datacontext->getObject($daoPositions);
//        $view->datas = $getObj;
        return $view;
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

        $view = new CJView("staff/lists", CJViewType::HTML_VIEW_ENGINE);
//        $daoStaff = new PositionsType();
//        $getObj = $this->datacontext->getObject($daoStaff);
//        $view->datas = $getObj;
        return $view;
    }

    // end serviec view staff
    // start serviec view titleName

    public function titleNameAdd() {
        $view = new CJView("titlename/add", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function titleNameEdit($id) {
        $view = new CJView("titlename/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoTitleName = new TitleName();
        $daoTitleName->setTitleNameId($id);
        $getObj = $this->datacontext->getObject($daoTitleName);
        $view->datas = $getObj;
        return $view;
    }

    public function titleNameLists() {
        $view = new CJView("titlename/lists", CJViewType::HTML_VIEW_ENGINE);
//        $daoTitleName = new TitleName();
//        $getObj = $this->datacontext->getObject($daoTitleName);
//        $view->datas = $getObj;
        
        return $view;
    }

    // end serviec view titleName
}
