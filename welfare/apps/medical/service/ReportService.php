<?php

namespace apps\medical\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;
use apps\medical\interfaces\IReportService;
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



        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->setCode("medical001");
        $query = $this->datacontext->getObject($welfare)[0];

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $query->welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];

        $dateStart = $dateBudget["startDate"];
        $dateEnd = $dateBudget["endDate"];

        $sql1 = "select mb.fname,mb.lname,whis.welfareId,wc.conditionsId,whis.memberId,wd.quantity,mb.idCard,mb.department1,mb.faculty1,"
                . "sum(whis.amount) as payment,wd.quantity-sum(whis.amount) as balance,wel.dateStart,wel.dateEnd,titles1 "
                . "from welfarehistory whis "
                . "join welfaredetails wd "
                . "on wd.detailsId = whis.detailsId "
                . "join welfare wel "
                . "on wel.welfareId = whis.welfareId and wel.code = 'medical001' "
                . "join welfareconditions wc "
                . "on wc.detailsId = wd.detailsId "
                . "join v_fullmember mb "
                . "on mb.memberId = whis.memberId and mb.employeeTypeId = wc.valuex and wc.fieldMap = 'employeeTypeId' "
                . "where whis.dateCreated between :dateStart and :dateEnd "
                . "group by whis.memberId ";
        
        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd
        );

        $budget = $this->datacontext->pdoQuery($sql1, $param);
       

        $f = fopen('php://memory', 'w');
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "รหัสบัตรประชาชน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อผู้เบิกค่ารักษาพยาบาล" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "จำนวนค่ารักษาพยาบาล" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "จำนวนเงินคงเหลือ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "หน่วยงานที่สังกัด" . "\"\r\n"));
        foreach ($budget as $key2 => $value2) {
            fputs($f, iconv("UTF-8", "windows-874", "\"'" . $budget[$key2]['idCard'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $budget[$key2]['titles1'] . " " . $budget[$key2]['fname'] . " " . $budget[$key2]['lname'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $budget[$key2]['payment'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $budget[$key2]['balance'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $budget[$key2]['department1'] . "" . $budget[$key2]['faculty1'] . "\"\r\n"));

            // $newFields = array(
            //   array($objMember[$key]->idCard, utf8_encode($objMember[$key]->fname), $objMember[$key]->lname));
            // fputcsv($f, $objMember);
        }
        fseek($f, 0);
        header('Content-Type: application/csv; charset=windows-874');
        header('Content-Disposition: attachment; filename="report_member.csv";');
        fpassthru($f);
        exit();
    }

}
