<?php
namespace apps\retire\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use apps\retire\interfaces\IRetireService;

class RetireService extends CServiceBase implements IRetireService{
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }
    
    


   



}
