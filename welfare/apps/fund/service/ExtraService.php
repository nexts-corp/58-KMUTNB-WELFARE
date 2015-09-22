<?php

namespace apps\fund\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\fund\interfaces\IExtraService;

class ExtraService extends CServiceBase implements IExtraService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function lists() {
        $sql = "SELECT "
                . "mb.memberId, "
                . "mb.idCard, "
                . "mb.fname, "
                . "mb.lname, "
                . "mb.department1, "
                . "mb.faculty1, "
                . "format(tb.saving,2)as saving, "
                . "format(tb.grantInAid,2) as grantInAid, "
                . "format(tb.total,2) as total, "
                . "tb.dateNotice "
                . "FROM fundExtra tb "
                . "join v_fullmember mb on mb.memberId = tb.memberId "
                . "where tb.fundExId in ( "
                . " select max(fundExId) from fundExtra group by memberId ) "
                . "order by tb.dateCreated desc";
        $datas = $this->datacontext->pdoQuery($sql);
        $i = 1;
        foreach ($datas as $key => $value) {
            $datas[$key]["rowNo"] = $i++;
            foreach ($value as $key2 => $value2) {
                if ($key2 == "dateNotice") {
                    $date = explode("-", $value2);
                    $date = $date[2] . "-" . $date[1] . "-" . intval($date[0] + 543);
                    $datas[$key][$key2] = $date;
                }
            }
        }
        return $datas;
    }

    public function save() {
        $mem = new \apps\member\model\FullMember();
        return $this->datacontext->getObject($mem);
    }

}
