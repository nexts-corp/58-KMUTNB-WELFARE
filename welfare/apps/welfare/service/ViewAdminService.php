<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\taxonomy\service\TaxonomyService;
use apps\common\service\CommonService;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IViewAdminService;
use apps\welfare\entity\Welfare;
use apps\welfare\entity\Details;
use apps\welfare\entity\Conditions;

class ViewAdminService extends CServiceBase implements IViewAdminService {

    public $datacontext;
    public $taxonomy;
    public $common;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new TaxonomyService();
        $this->common = new CommonService();
    }

    public function welfareLists() {
        $view = new CJView("admin/welfare/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare = new Welfare();
        $obj = $this->datacontext->getObject($daoWelfare);
        $obj = $this->common->afterGet($obj);
//        if (count($obj) > 0) {
//            foreach ($obj as $key => $value) {
//                if ($value->dateStart != "") {
//                    $dsY = $value->dateStart->format('Y') + 543;
//                    $obj[$key]->dateStart = $value->dateStart->format('d-m-' . $dsY);
//                }
//                if ($value->dateEnd != "") {
//                    $deY = $value->dateEnd->format('Y') + 543;
//                    $obj[$key]->dateEnd = $value->dateEnd->format('d-m-' . $deY);
//                }
//            }
//        }

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
        $wel = new WelfareService();
        $view->welfare = $wel->get($welfareId);
        $view->unit = $this->taxonomy->getPCode("unit");
        return $view;
    }

}
