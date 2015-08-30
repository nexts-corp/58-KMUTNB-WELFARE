<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IConditionService;

use apps\welfare\entity\Condition;

class ConditionService extends CServiceBase implements IConditionService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function delete($Id) {
        
    }

    public function save($data) {
        
    }

    public function update($data) {
        
    }

}
