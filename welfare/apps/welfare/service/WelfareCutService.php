<?php
namespace apps\welfare\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\common\entity\Welfare;

use apps\welfare\interfaces\IWelfareCutService;
class WelfareCutService extends CServiceBase implements IWelfareCutService{
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }
    

//put your code here
}
