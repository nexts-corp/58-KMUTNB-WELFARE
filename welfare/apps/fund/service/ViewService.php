<?php

namespace apps\fund\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\fund\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function policyAdminAdd() {
        $view = new CJView("policy/admin/add", CJViewType::HTML_VIEW_ENGINE);
        $fundType = new \apps\taxonomy\entity\Taxonomy();
        $fundType->pCode = "fundType";
        $view->fundType = $this->datacontext->getObject($fundType);
        return $view;
    }

    public function policyAdminLists() {
        $view = new CJView("policy/admin/lists", CJViewType::HTML_VIEW_ENGINE);
        $sql = "select pol.policyId,pol.name,pol.description,ft.value1 as fundType "
                . "from apps\\fund\\entity\\Policy pol "
                . "join apps\\taxonomy\\entity\\Taxonomy ft "
                . "with ft.id = pol.fundTypeId ";
        $data = $this->datacontext->getObject($sql);
        $i = 1;
        foreach ($data as $key => $value) {
            $data[$key]['rowNo'] = $i++;
        }
        $view->lists = $data;
        return $view;
    }

    public function policyAdminEdit($policyId) {
        $view = new CJView("policy/admin/edit", CJViewType::HTML_VIEW_ENGINE);
        $sql = "select pol.policyId,pol.name,pol.fundTypeId,pol.description,ft.value1 as fundType "
                . "from apps\\fund\\entity\\Policy pol "
                . "join apps\\taxonomy\\entity\\Taxonomy ft "
                . "with ft.id = pol.fundTypeId "
                . "where pol.policyId  = :policyId";
        $param = array(
            "policyId" => $policyId
        );
        $data = $this->datacontext->getObject($sql, $param);
        $view->datas = $data;
        $tax = new \apps\taxonomy\entity\Taxonomy();
        $tax->pCode = "fundType";
        $view->fundType = $this->datacontext->getObject($tax);

        return $view;
    }

    public function employeeAdminLists() {
        $view = new CJView("employee/admin/lists", CJViewType::HTML_VIEW_ENGINE);
        $emp = new EmployeeService();
        $view->lists = $emp->lists();
        return $view;
    }

    public function employeeUserLists() {

        if ($this->getRequest()->memberId != "") {
            $memberId = $this->getRequest()->memberId;
            $view = new CJView("employee/admin/user", CJViewType::HTML_VIEW_ENGINE);
        } else {
            $memberId = $this->getCurrentUser()->code;
        }
        $emp = "select "
                . "fem.fundEmpId, "
                . "plc.name, "
                . "fem.saving, "
                . "fem.myBenefit, "
                . "fem.employerBenefit, "
                . "fem.grantInAid, "
                . "fem.total, "
                . "fem.dateNotice "
                . "from apps\\fund\\entity\\FundEmployee fem "
                . "join apps\\fund\\entity\\Policy plc "
                . "with plc.policyId = fem.policyId "
                . "where fem.memberId = :memberId "
                . "order by fem.fundEmpId desc";
        $param = array(
            "memberId" => $memberId
        );
        $datas = $this->datacontext->getObject($emp, $param);
        $i = 1;
        foreach ($datas as $key => $value) {
            $datas[$key]['rowNo'] = $i++;
            foreach ($value as $key2 => $value2) {
                if ($key2 == "dateNotice") {
                    $date = explode("-", $value2->format("Y-m-d"));
                    $date = $date[2] . "-" . $date[1] . "-" . intval($date[0] + 543);
                    $datas[$key][$key2] = $date;
                }
            }
        }
        $mb = new \apps\member\service\MemberService();
        $view->member = $mb->find("memberId", $memberId)[0];
        $view->lists = $datas;

        return $view;
    }

}
