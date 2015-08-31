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
        
        $userType = new Taxonomy();
        $userType->pCode = "userType";
        $view->userType = $this->datacontext->getObject($userType);
        
        $matier = new Taxonomy();
        $matier->pCode = "matier";
        $view->matier = $this->datacontext->getObject($matier);
        
        return $view;
    }

    public function memberEdit($id) {
        $view = new CJView("member/edit", CJViewType::HTML_VIEW_ENGINE);
        $member = new \apps\member\entity\Member();
        $member->setMemberId($id);
        $member = $this->datacontext->getObject($member)[0];
        
        $member->dob = $member->dob->format('d-m-Y');
        $member->workStartDate = $member->workStartDate->format('d-m-Y');
        
        $user = new \apps\user\entity\User();
        $user->memberId = $member->memberId;
        $user = $this->datacontext->getObject($user)[0];
        $member->userTypeId = $user->userTypeId;
        $view->datas = $member;
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

}
