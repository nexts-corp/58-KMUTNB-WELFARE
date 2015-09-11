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
        if (count($retire) > 0) {
            $view->retire = $retire;
        } else {
            $date = new \DateTime('now');
            $reServ = new RetireService();
            $data = $reServ->preview($date->format('Y'));
            $view->retire = $data;
        }
        //print_r($date->format('Y'));
        //exit();
        return $view;
    }

}
