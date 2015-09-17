<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\insurance\interfaces\ISSOService;

class SSOService extends CServiceBase implements ISSOService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function lists() {
        $sql = "SELECT "
                . "mb.idCard, "
                . "titlename.value1 as titleName, "
                . "mb.fname, "
                . "mb.lname, "
                . "dep.value1 as department, "
                . "STR_TO_DATE(mb.workStartDate,'%Y-%m-%d') as workStartDate, "
                . "tb.hospital, "
                . "STR_TO_DATE(tb.issuedDate,'%Y-%m-%d') as issuedDate, "
                . "STR_TO_DATE(tb.expireDate,'%Y-%m-%d') as expireDate, "
                . "STR_TO_DATE(tb.dateCreated,'%Y-%m-%d %H:%i:%s') as dateCreated "
                . "FROM ( "
                . "select * "
                . "from kmutnb_welfare.insurance "
                . "order by dateCreated desc "
                . ") tb "
                . "join member mb on mb.memberId = tb.memberId "
                . "join taxonomy titleName on titleName.id = mb.titleNameId "
                . "join taxonomy dep on dep.id = mb.departmentId "
                . "group by tb.memberId "
                . "order by tb.dateCreated desc";
        $datas = $this->datacontext->pdoQuery($sql);
        $i = 1;
        foreach ($datas as $key => $value) {
            $datas[$key]["rowNo"] = $i++;
            foreach ($value as $key2 => $value2) {
                if (strpos($key2, "Date") || $key2=="dateCreated") {
                    
                    $dateTime = explode(" ", $value2);
                    $date = $dateTime[0];
                    $date = explode("-", $date);
                    $date = $date[2] . "-" . $date[1] . "-" . intval($date[0] + 543);
                    if (!empty($dateTime[1])) {
                        $datas[$key][$key2] = $date." ".$dateTime[1];
                    } else {
                        $datas[$key][$key2] = $date;
                    }
                }
            }
        }
        return $datas;
    }

}
