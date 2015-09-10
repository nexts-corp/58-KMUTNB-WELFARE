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

        $reServ = new RetireService();
        $data = $reServ->preview($retireYear);
        return $view;
    }

}
