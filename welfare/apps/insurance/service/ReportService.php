<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;
use apps\insurance\interfaces\IReportService;
use apps\user\entity\User;

class ReportService extends CServiceBase implements IReportService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext("default");
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
    }

    public function reportList() {

        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;

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
                    $datas[$key][$key2] = $date;
//                    if (!empty($dateTime[1])) {
//                        $datas[$key][$key2] = $date . " " . $dateTime[1];
//                    } else {
//                        $datas[$key][$key2] = $date;
//                    }
                }
            }
        }
        
        $f = fopen('php://memory', 'w');
        fputs($f, iconv("UTF-8", "windows-874", " ,," . "รายงานสรุปข้อมูลประกันสังคม" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "รหัสบัตรประชาชน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อผู้ได้รับประกันสังคม" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "สถานพยาบาล" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "หน่วยงานที่สังกัด" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "วันออกบัตร" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "วันหมดอายุ" . "\"\r\n"));
        foreach ($datas as $key2 => $value2) {
            fputs($f, iconv("UTF-8", "windows-874", "\"'" . $datas[$key2]['idCard'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $datas[$key2]['titleName'] . " " . $datas[$key2]['fname'] . " " . $datas[$key2]['lname'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $datas[$key2]['hospital'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $datas[$key2]['department'] . "" . $datas[$key2]['faculty'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $datas[$key2]['issuedDate'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $datas[$key2]['expireDate'] . "\"\r\n"));

            // $newFields = array(
            //   array($objMember[$key]->idCard, utf8_encode($objMember[$key]->fname), $objMember[$key]->lname));
            // fputcsv($f, $objMember);
        }
        fseek($f, 0);
        header('Content-Type: application/csv; charset=windows-874');
        header('Content-Disposition: attachment; filename="report_insurance.csv";');
        fpassthru($f);
        exit();
    }

}
