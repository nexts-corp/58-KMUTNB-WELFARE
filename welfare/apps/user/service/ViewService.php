<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\user\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function memberAdd() {
        $view = new CJView("member/add", CJViewType::HTML_VIEW_ENGINE);
        $view->academicPositions = $this->datacontext->getObject(new \apps\basics\entity\AcademicType());
        //$view->rank = $this->datacontext->getObject(new \apps\common\entity\Rank());
        $view->titleName = $this->datacontext->getObject(new \apps\common\entity\TitleName());
//        $view->positionsType = $this->datacontext->getObject(new \apps\common\entity\PositionsType());
        //$view->positionsWork = $this->datacontext->getObject(new \apps\common\entity\PositionsWork());
//        $view->faculty = $this->datacontext->getObject(new \apps\common\entity\Faculty());
//        $view->register = $this->datacontext->getObject(new \apps\common\entity\Department());
//        $view->userType = $this->datacontext->getObject(new \apps\common\entity\UserType());
        return $view;
    }

    public function memberEdit($id) {
        $view = new CJView("member/edit", CJViewType::HTML_VIEW_ENGINE);
        $filter = new \apps\member\entity\Member();
        $filter->setMemberId($id);
        $dao_register = $this->datacontext->getObject($filter);
        $view->datas = $dao_register;
        //print_r($view);
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
