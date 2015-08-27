<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\user\interfaces\IViewService;
use apps\taxonomy\entity\Taxonomy;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function memberAdd() {
        $view = new CJView("member/add", CJViewType::HTML_VIEW_ENGINE);
        $academic = new Taxonomy();
        $academic->pCode = "academic";
        $view->academic = $this->datacontext->getObject($academic);
        
        $titleName = new Taxonomy();
        $titleName->pCode = "titleName";
        $view->titleName = $this->datacontext->getObject($titleName);
        
        $gender = new Taxonomy();
        $gender->pCode = "gender";
        $view->gender = $this->datacontext->getObject($gender);
        
        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);
        
        $position = new Taxonomy();
        $position->pCode = "position";
        $view->position = $this->datacontext->getObject($position);
        
        $department = new Taxonomy();
        $department->pCode = "department";
        $view->department = $this->datacontext->getObject($department);
        
        $faculty = new Taxonomy();
        $faculty->pCode = "faculty";
        $view->faculty = $this->datacontext->getObject($faculty);
        
        
        
        return $view;
    }

    public function memberEdit($id) {
        $view = new CJView("member/edit", CJViewType::HTML_VIEW_ENGINE);
        $filter = new \apps\member\entity\Member();
        $filter->setMemberId($id);
        $dao_register = $this->datacontext->getObject($filter);
//        print_r($dao_register[0]->dob);
        $datebrith = $dao_register[0]->dob->format('d-m-Y');
        //print_r($datebrith);
        $view->dobs = $datebrith;
        $view->datas = $dao_register;
//        print_r($view);
        return $view;
    }

    public function memberLists() {
        $view = new CJView("member/lists", CJViewType::HTML_VIEW_ENGINE);
        //$listregister = new \apps\common\entity\Register();
        $listregister = new \apps\member\entity\Member();
        $listreg = $this->datacontext->getObject($listregister);
        $view->list = $listreg;
        return $view;
    }

    public function typeAdd() {
        $view = new CJView("type/add", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function typeEdit($id) {
        $view = new CJView("type/edit", CJViewType::HTML_VIEW_ENGINE);
        $filter = new \apps\common\entity\UserType();
        $filter->setUserTypeId($id);
        $dao_usertype = $this->datacontext->getObject($filter);
        $view->data = $dao_usertype;
        return $view;
    }

    public function typeLists() {
        $view = new CJView("type/lists", CJViewType::HTML_VIEW_ENGINE);
        $filter = new \apps\common\entity\UserType();
        $dao_usertype = $this->datacontext->getObject($filter);
        $view->cuss = $dao_usertype;
        return $view;
    }

}
