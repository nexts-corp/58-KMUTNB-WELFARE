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

        $sql = "SELECT  mem.fname,mem.lname, ti.value1 as titlename, ac.value1 as academic ,fac.value1 as faculty,de.value1 as department,
mem.dob + interval 603 year as dateOut,
CASE
    WHEN mem.workStartDate + interval 10 year >= curdate() THEN 10000
    WHEN mem.workStartDate + interval 15 year >= curdate() THEN 15000
    WHEN mem.workStartDate + interval 20 year >= curdate() THEN 20000
    WHEN mem.workStartDate + interval 25 year >= curdate() THEN 25000
    WHEN mem.workStartDate + interval 30 year >= curdate() THEN 30000
    ELSE NULL
END AS amount
FROM member mem
left join taxonomy fac on mem.facultyId = fac.id
left join taxonomy de on mem.departmentId = de.id
left join taxonomy ti on mem.titleId = ti.id
left join taxonomy ac on mem.academicId = ac.id
where mem.dob + interval 60 year >= curdate() GROUP BY mem.memberId";

        $info = $this->datacontext->pdoQuery($sql);
        if ($info) {
            $view->retire = $info;
            return $view;
        } else {
            return $view;
        }
    }

}
