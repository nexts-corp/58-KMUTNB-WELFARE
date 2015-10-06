<?php

namespace apps\retire\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\retire\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function retireList() {
        $view = new CJView("lists", CJViewType::HTML_VIEW_ENGINE);

        $retire = $this->getRequest()->retire;
        $searchName = $this->getRequest()->searchName;
        $filterCode = $this->getRequest()->filterCode;
        $filtervalue = $this->getRequest()->filtervalue;
        $datafilter = $this->getRequest();



        if ($searchName != "") {
            $filter = new RetireService();
            $view->retire = $filter->preview($datafilter)["member"];
            $view->total = $filter->preview($datafilter)["total"];
        } else if ($filterCode != "") {

            $filter = new RetireService();
            $view->retire = $filter->preview($datafilter)["member"];
            $view->total = $filter->preview($datafilter)["total"];
//            print_r($datafilter);
//            exit();
        } else if ($retire != "") {
//            print_r($datafilter);
//            exit();
            $filter = new RetireService();
            $view->retire = $filter->preview($datafilter)["member"];
            $view->total = $filter->preview($datafilter)["total"];
//            print_r($view);
//            exit();
        } else {
            $date = new \DateTime('now');
            $datafilter->present = $date->format('Y');
            $filter = new RetireService();
            $view->retire = $filter->preview($datafilter)["member"];
            $view->total = $filter->preview($datafilter)["total"];
//            print_r($filter->preview($datafilter));
//            exit();
        }

        //print_r($date->format('Y'));
        //exit();
        return $view;
    }

}
