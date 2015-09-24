<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IViewUserService;
use apps\welfare\entity\Welfare;

class ViewUserService extends CServiceBase implements IViewUserService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

}
