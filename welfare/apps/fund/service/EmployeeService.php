<?php

namespace apps\fund\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\fund\interfaces\IEmployeeService;

class EmployeeService extends CServiceBase implements IEmployeeService {

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
                . "format(tb.myBenefit,2) as myBenefit,  "
                . "format(tb.employerBenefit,2) as employerBenefit, "
                . "format(tb.grantInAid,2) as grantInAid, "
                . "format(tb.total,2) as total, "
                . "tb.dateNotice "
                . "FROM fundemployee tb "
                . "join v_fullmember mb on mb.memberId = tb.memberId "
                . "where tb.fundEmpId in ( "
                . " select max(fundEmpId) from fundemployee group by memberId ) "
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

    public function changeHospital($ssoHospital) {
        $mb = new \apps\member\service\MemberService();
        $member = $mb->find("memberId", $this->getCurrentUser()->code)[0];

        $hospital = new EmployeeHospital();
        $hospital->memberId = $member->memberId;
        $data = $this->datacontext->getObject($hospital);

        if (count($data) > 0) {
            $data[0]->hospital = $ssoHospital->hospital;
            $return = $this->datacontext->updateObject($data);
        } else {
            $ssoHospital->idCard = $member->idCard;
            $ssoHospital->memberId = $member->memberId;
            $return = $this->datacontext->saveObject($ssoHospital);
        }
        return $return;
    }

}
