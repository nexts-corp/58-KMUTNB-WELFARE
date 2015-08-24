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
        $view = new CJView("retire/lists", CJViewType::HTML_VIEW_ENGINE);

//        $sql = "SELECT concat(ti.titleNameTh,' ',re.registerNameTh,' ',re.registerLastNameTh) as fullname ,de.departmentNameTh,
//re.registerDateofBirth + interval 60 year as dateOut,
//CASE
//    WHEN re.registerDateAdded + interval 10 year >= curdate() THEN 10000
//    WHEN re.registerDateAdded + interval 15 year >= curdate() THEN 15000
//    WHEN re.registerDateAdded + interval 20 year >= curdate() THEN 20000
//    WHEN re.registerDateAdded + interval 25 year >= curdate() THEN 25000
//    WHEN re.registerDateAdded + interval 30 year >= curdate() THEN 30000
//    ELSE NULL
//END AS amount
//FROM register re
//left join department de on re.departmentId = de.departmentId
//left join titlename ti on re.titleNameId = ti.titleNameId
//where re.registerDateofBirth + interval 60 year >= curdate()";
//        $info = $this->datacontext->pdoQuery($sql);
//        if ($info) {
//            $view->retire = $info;
//            return $view;
//        }
//        else{}
            return $view;
          
        
    }

}
