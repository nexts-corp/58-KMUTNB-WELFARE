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

}
