<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\member\interfaces\IViewService;
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

        $dob = $member->dob->format('d-m-Y');
        $mem = explode("-", $dob);
        $member->dob = $mem[0]."-".$mem[1]."-".(intval($mem[2]) + 543);
        
        $workStartDate = $member->workStartDate->format('d-m-Y');
        $wsd = explode("-", $workStartDate);
        $member->workStartDate = $wsd[0]."-".$wsd[1]."-".(intval($wsd[2]) + 543);

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
        $sql = "select * "
                . "FROM member mem1 "
                . "INNER JOIN taxonomy tax1 "
                . "on mem1.titleId = tax1.id "
                . "WHERE mem1.memberId in ( "
                . "select mem2.memberId "
                . "FROM member mem2 "
                . "INNER JOIN taxonomy tax2 "
                . "on mem2.memberActiveId = tax2.id "
                . "WHERE tax2.pCode = 'memberActive' and tax2.code = 'working' "
                . ")";
        $data = $this->datacontext->pdoQuery($sql);
        // print_r($data);
        $view->lists = $data;
        return $view;
    }
}
