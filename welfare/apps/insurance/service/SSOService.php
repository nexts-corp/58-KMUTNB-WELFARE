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
                . "mb.memberId, "
                . "mb.idCard, "
                . "ifnull(academic.value1,titlename.value1) as titleName, "
                . "mb.fname, "
                . "mb.lname, "
                . "dep.value1 as department, "
                . "fac.value1 as faculty, "
                . "STR_TO_DATE(mb.workStartDate,'%Y-%m-%d') as workStartDate, "
                . "tb.hospital, "
                . "STR_TO_DATE(tb.issuedDate,'%Y-%m-%d') as issuedDate, "
                . "STR_TO_DATE(tb.expireDate,'%Y-%m-%d') as expireDate, "
                . "STR_TO_DATE(tb.dateCreated,'%Y-%m-%d %H:%i:%s') as dateCreated "
                . "FROM ( "
                . "select * "
                . "from kmutnb_welfare.sso "
                . "order by dateCreated desc "
                . ") tb "
                . "join v_member mb on mb.memberId = tb.memberId "
                . "join taxonomy titleName on titleName.id = mb.titleNameId "
                . "join taxonomy academic on academic.id = mb.academicId "
                . "join taxonomy dep on dep.id = mb.departmentId "
                . "join taxonomy fac on fac.id = mb.facultyId "
                . "group by tb.memberId "
                . "order by tb.dateCreated desc";
        $datas = $this->datacontext->pdoQuery($sql);
        $i = 1;
        foreach ($datas as $key => $value) {
            $datas[$key]["rowNo"] = $i++;
            foreach ($value as $key2 => $value2) {
                if (strpos($key2, "Date") || $key2 == "dateCreated") {

                    $dateTime = explode(" ", $value2);
                    $date = $dateTime[0];
                    $date = explode("-", $date);
                    $date = $date[2] . "-" . $date[1] . "-" . intval($date[0] + 543);
                    if (!empty($dateTime[1])) {
                        $datas[$key][$key2] = $date . " " . $dateTime[1];
                    } else {
                        $datas[$key][$key2] = $date;
                    }
                }
            }
        }
        return $datas;
    }

    public function save($sso) {
        if ($sso->issuedDate != "") {
            $date = explode("-", $sso->issuedDate);
            $date[2] = intVal($date[2]) - 543;
            $date = $date[2] . "-" . $date[1] . "-" . $date[0];
            $sso->issuedDate = new \DateTime($date);
        }
        if ($sso->expireDate != "") {
            $date = explode("-", $sso->expireDate);
            $date[2] = intVal($date[2]) - 543;
            $date = $date[2] . "-" . $date[1] . "-" . $date[0];
            $sso->expireDate = new \DateTime($date);
        }
        if (!$this->datacontext->saveObject($sso)) {
            $this->getResponse()->add("msg", $this->datacontext->getLastMessage());
            return false;
        } else {
            return true;
        }
    }

}
