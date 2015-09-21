<?php

namespace apps\fund\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\fund\interfaces\IPolicyService;
use apps\fund\entity\Policy;

class PolicyService extends CServiceBase implements IPolicyService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($policy) {
        return $this->datacontext->saveObject($policy);
    }

    public function update($policy) {
        return $this->datacontext->updateObject($policy);
    }

}
