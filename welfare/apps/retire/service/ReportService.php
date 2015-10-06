<?php

namespace apps\retire\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;
use apps\retire\interfaces\IReportService;
use apps\user\entity\User;

class ReportService extends CServiceBase implements IReportService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext("default");
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
    }

    public function reportList() {
//        $date = new \DateTime('now');
//        $date->format('%Y');

        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
//        $date->format('Y-m-d')
        $query1 = "select tax.id "
                . "from taxonomy tax  "
                . "where tax.code = 'employee' and tax.pCode = 'employeeType' ";
        $welfare = $this->datacontext->pdoQuery($query1);
        $employeeTypeId = $welfare[0]['id'];

        $query = "select mb.memberId,mb.titles1,mb.fname,mb.lname,mb.department1, "
                . "mb.faculty1,mb.dob,mb.workStartDate,TIMESTAMPDIFF(YEAR,mb.workStartDate,curdate()) as ageWork, "
                . "welEmp.employeeTypeId,mb.employeeType1,welEmp.quantity,welStart.workStartDate,welEnd.workEndDate,mb.idCard "
                . "from v_fullmember mb "
                . "join (select welcon.detailsId,welcon.conditionsId,welcon.valuex as employeeTypeId,welde.quantity "
                . "from welfareconditions welcon "
                . "join welfaredetails welde on welcon.detailsId = welde.detailsId "
                . "join welfare wel on wel.welfareId = welde.welfareId "
                . "where wel.code='retire001' and welcon.fieldMap = 'employeeTypeId' "
                . "and welcon.valuex = :employeeTypeIds "
                . ")welEmp on mb.employeeTypeId = welEmp.employeeTypeId "
                . "join (select detailsId,conditionsId,fieldMap,operations,valuex as workStartDate "
                . "from welfareconditions where detailsId in ( "
                . "select details.detailsId from welfaredetails details "
                . "join welfare wel on details.welfareId = wel.welfareId and "
                . "wel.code='retire001' )and fieldMap = 'workStartDate' and operations = '>=' "
                . ") welStart on welEmp.detailsId = welStart.detailsId "
                . "join (select detailsId,conditionsId,fieldMap,operations,valuex as workEndDate "
                . "from welfareconditions where detailsId in ( select details.detailsId from welfaredetails details "
                . "join welfare wel on details.welfareId = wel.welfareId and wel.code='retire001') "
                . "and fieldMap = 'workStartDate' and operations = '<') welEnd on welEmp.detailsId = welEnd.detailsId "
                . "where mb.employeeTypeId = :employeeTypeIds and mb.dob between :retireStart  and :retireEnd "
                . "and TIMESTAMPDIFF(YEAR,mb.workStartDate,:retireyear) >= welStart.workStartDate "
                . "and TIMESTAMPDIFF(YEAR,mb.workStartDate,:retireyear) < welEnd.workEndDate ";

        $retire = date('Y');
        $budget = intval($retire + 543);
        $retireStart = ($retire - 61) . "-10-01";
        $retireEnd = ($retire - 60) . "-09-30";
        $retireY = $retire . "-09-30";
        
        $param = array(
            "retireStart" => $retireStart,
            "retireEnd" => $retireEnd,
            "retireyear" => $retireY,
            "employeeTypeIds" => $employeeTypeId
        );
        
        $member = $this->datacontext->pdoQuery($query, $param);
        

        $f = fopen('php://memory', 'w');
        fputs($f, iconv("UTF-8", "windows-874", " ,," . "รายงานสรุปข้อมูลผู้เกษียนอายุประจำปี"." ".$budget. ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "รหัสบัตรประชาชน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อผู้เกษียนอายุ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "จำนวนเงินตอบแทน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "หน่วยงานที่สังกัด" . "\"\r\n"));
        foreach ($member as $key2 => $value2) {
            fputs($f, iconv("UTF-8", "windows-874", "\"'" . $member[$key2]['idCard'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $member[$key2]['titles1'] . " " . $member[$key2]['fname'] . " " . $member[$key2]['lname'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $member[$key2]['quantity'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $member[$key2]['department1'] . "" . $member[$key2]['faculty1'] . "\"\r\n"));

            // $newFields = array(
            //   array($objMember[$key]->idCard, utf8_encode($objMember[$key]->fname), $objMember[$key]->lname));
            // fputcsv($f, $objMember);
        }
        fseek($f, 0);
        header('Content-Type: application/csv; charset=windows-874');
        header('Content-Disposition: attachment; filename="report_retire.csv";');
        fpassthru($f);
        exit();
    }

}
