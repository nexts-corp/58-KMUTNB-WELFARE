<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\taxonomy\service\TaxonomyService;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IViewAdminService;
use apps\welfare\entity\Welfare;
use apps\welfare\entity\Details;
use apps\welfare\entity\Conditions;

class ViewAdminService extends CServiceBase implements IViewAdminService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new TaxonomyService();
    }

    public function welfareLists() {
        $view = new CJView("admin/welfare/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare = new Welfare();
        $obj = $this->datacontext->getObject($daoWelfare);

        if (count($obj) > 0) {
            foreach ($obj as $key => $value) {
                if ($value->dateStart != "") {
                    $dsY = $value->dateStart->format('Y') + 543;
                    $obj[$key]->dateStart = $value->dateStart->format('d-m-' . $dsY);
                }
                if ($value->dateEnd != "") {
                    $deY = $value->dateEnd->format('Y') + 543;
                    $obj[$key]->dateEnd = $value->dateEnd->format('d-m-' . $deY);
                }
            }
        }

        $view->datas = $obj;
        return $view;
    }

    public function welfareAdd() {
        $view = new CJView("admin/welfare/add", CJViewType::HTML_VIEW_ENGINE);
        $view->unit = $this->taxonomy->getPCode("unit");
        return $view;
    }

    public function welfareEdit() {
        $view = new CJView("admin/welfare/edit", CJViewType::HTML_VIEW_ENGINE);
        $welfareId = $this->getRequest()->welfareId;

        //  $wf = array();

        $welfare = new Welfare();
        $welfare->welfareId = $welfareId;
        $welfare = $this->datacontext->getObject($welfare)[0];

        $details = new Details();
        $details->welfareId = $welfareId;
        $details = $this->datacontext->getObject($details);

        $welfare->details = $details;


        foreach ($details as $key => $value) {
            $conditions = new Conditions();
            $conditions->detailsId = $value->detailsId;
            $conditions = $this->datacontext->getObject($conditions);
            $welfare->details[$key]->conditions = $conditions;
        }
        $view->welfare = $welfare;
       
//
//        $conditions = new Conditions();
//        $conditions->welfareId = $welfareId;
//        $conditions = $this->datacontext->getObject($conditions);
//
        $view->unit = $this->taxonomy->getPCode("unit");
        return $view;
    }

}
