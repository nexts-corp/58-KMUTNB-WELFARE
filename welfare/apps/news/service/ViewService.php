<?php
namespace apps\news\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use apps\news\interfaces\IViewService;

class ViewService  extends CServiceBase implements IViewService{
       
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function newsList() {
        $view = new CJView("news/lists", CJViewType::HTML_VIEW_ENGINE);
//        
        return $view; 
    }

    public function newsadd() {
        $view = new CJView("news/add", CJViewType::HTML_VIEW_ENGINE);
//       
        return $view;
    }

}
