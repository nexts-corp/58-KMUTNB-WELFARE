<?php
namespace apps\news\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use apps\news\interfaces\INewsService;
class NewsService extends CServiceBase implements INewsService{
    
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }
    
    

//put your code here
}
