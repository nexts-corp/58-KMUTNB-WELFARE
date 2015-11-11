<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;
use apps\welfare\interfaces\IReportService;
use apps\common\service\CommonService;
use apps\welfare\service\WelfareService;
use apps\welfare\entity\Conditions;
use apps\welfare\service\HistoryService;

class ReportService extends CServiceBase implements IReportService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext("default");
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
        $this->common = new CommonService();
    }

    public function reportList($detailsId) {


        $conditions = new Conditions();
        $conditions->detailsId = $detailsId;
        $conditions = $this->datacontext->getObject($conditions);
        $conditions = $this->common->afterGet($conditions, array("welfareId", "detailsId", "dateCreated", "dateUpdated", "createBy", "updateBy"));


        $daoWelfare = new WelfareService();
        $objMember = $daoWelfare->preview($conditions);


        $f = fopen('php://memory', 'w');

        fputs($f, iconv("UTF-8", "windows-874", " ,," . "ผู้มีสิทธิ์ได้รับสวัสดิการ" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "รหัสบัตรประชาชน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "คำนำหน้า" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "นามสกุล" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "หน่วยงานที่สังกัด" . "\"\r\n"));
        foreach ($objMember as $key => $value) {
            fputs($f, iconv("UTF-8", "windows-874", "\"'" . $value['idCard'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['titles1'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['fname'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['lname'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['department1'] . "" . $value['faculty1'] . "\"\r\n"));

            // $newFields = array(
            //   array($value->idCard, utf8_encode($value->fname), $value->lname));
            // fputcsv($f, $objMember);
        }
        fseek($f, 0);
        header('Content-Type: application/csv; charset=windows-874');
        header('Content-Disposition: attachment; filename="report_welfare.csv";');
        fpassthru($f);
        exit();
    }

    public function reportApprove() {

        $daoCheck = new HistoryService();
        $data = "";
        $objApprove = $daoCheck->checkStatus($data);

        $f = fopen('php://memory', 'w');

        fputs($f, iconv("UTF-8", "windows-874", " ,," . "รายงานการอนุมัติสวัสดิการ" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อ-นามสกุล" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "เพศ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "สังกัด" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ประเภทพนักงาน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อสวัสดิการ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "สถานะ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "วันที่ปรับปรุง" . "\"\r\n"));
        foreach ($objApprove as $key => $value) {
            fputs($f, iconv("UTF-8", "windows-874", "\"'" . $value['title'] . "" . $value['fname'] . "" . $value['lname'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['gender1'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['department1'] . "" . $value['faculty1'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['employeeType1'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['name'] . "\","));
            if($value['statusApprove']=="Y"){
                $statusApprove="อนุมัติ";
            }else{
                $statusApprove="ไม่อนุมัติ";
            }
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $statusApprove . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['dateUpdated'] . "\"\r\n"));

            // $newFields = array(
            //   array($value->idCard, utf8_encode($value->fname), $value->lname));
            // fputcsv($f, $objMember);
        }
        fseek($f, 0);
        header('Content-Type: application/csv; charset=windows-874');
        header('Content-Disposition: attachment; filename="report_welfare.csv";');
        fpassthru($f);
        exit();
    }

}
