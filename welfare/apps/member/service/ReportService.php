<?php

namespace apps\member\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;
use apps\member\interfaces\IReportService;
use apps\user\entity\User;

class ReportService extends CServiceBase implements IReportService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext("default");
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
    }

    public function reportList() {


        //$view = new CJView("admin/report/listReport", CJViewType::HTML_VIEW_ENGINE);

        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
        $searchName = $this->getRequest()->searchName;
        $filterCode = $this->getRequest()->filterCode;
        $filtervalue = $this->getRequest()->filtervalue;
        $datafilter = $this->getRequest();



        $param = array();
        $sql = "select mem1 "
                . "FROM apps\\member\\model\\FullMember mem1 ";
        $objMember = $this->datacontext->getObject($sql, $param);

        $f = fopen('php://memory', 'w');

        fputs($f, iconv("UTF-8", "windows-874", " ,," . "รายงานสรุปข้อมูลสมาชิก" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "รหัสบัตรประชาชน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "คำนำหน้า" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "นามสกุล" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "หน่วยงานที่สังกัด" . "\"\r\n"));
        foreach ($objMember as $key => $value) {
            fputs($f, iconv("UTF-8", "windows-874", "\"'" . $objMember[$key]->idCard . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $objMember[$key]->titles1 . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $objMember[$key]->fname . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $objMember[$key]->lname . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $objMember[$key]->department1 . "" . $objMember[$key]->faculty1 . "\"\r\n"));

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
   
    //ddddd

}
