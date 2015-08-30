<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IViewService;
use apps\welfare\entity\Welfare;
use apps\welfare\entity\Condition;
use apps\taxonomy\entity\Taxonomy;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    // start page welfare add
    public function welfareAdd() {
        $view = new CJView("welfare/add", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    // end page welfare add
    // start page welfare edit

    public function welfareEdit($id) {
        $view = new CJView("welfare/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare= new Welfare();
        $daoWelfare->setWelfareId($id);
        $obj=$this->datacontext->getObject($daoWelfare);
        if (count($obj) > 0) {
            foreach ($obj as $key => $value) {
                $obj[$key]->dateStart = $value->dateStart->format('d-m-Y');
                $obj[$key]->dateEnd = $value->dateEnd->format('d-m-Y');
            }
        }
        $view->datas=$obj;
        return $view;
    }

    //end page welfare edit
    //start page welfare list

    public function welfareLists() {
        $view = new CJView("welfare/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare = new Welfare();
        $obj = $this->datacontext->getObject($daoWelfare);

        if (count($obj) > 0) {
            foreach ($obj as $key => $value) {
                $obj[$key]->dateStart = $value->dateStart->format('d-m-Y');
                $obj[$key]->dateEnd = $value->dateEnd->format('d-m-Y');
            }
        }

        $view->datas = $obj;

        return $view;
    }

    //end page welfare list
    //start page condition add 

    public function conditionAdd($id) {
        $view = new CJView("condition/add", CJViewType::HTML_VIEW_ENGINE);
        
        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);
        
        
        return $view;
    }

    //end page condition view add
    //start page condition view edit 

    public function conditionEdit($id) {
        $view = new CJView("condition/edit", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    //end page condition view edit
    //start page condition view lists 

    public function conditionLists($id) {
        $view = new CJView("condition/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoCondition=new Condition();
        $daoCondition->setWelfareId($id);
        $obj=$this->datacontext->getObject($daoCondition);
        $view->datas=$obj;
        return $view;
    }

    //end page condition view lists
}
