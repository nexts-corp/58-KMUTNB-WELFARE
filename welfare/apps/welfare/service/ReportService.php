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
            if ($value['statusApprove'] == "Y") {
                $statusApprove = "อนุมัติ";
            } else {
                $statusApprove = "ไม่อนุมัติ";
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

    public function reportRight() {

        $memberId = $this->getRequest()->memberId;
        $mb = new \apps\member\service\MemberService();
        $member = $mb->find("memberId", $memberId)[0];

        $sqlDetails = "select wfc.detailsId  from welfareconditions wfc
                join welfaredetails wfd on wfc.detailsId = wfd.detailsId
                join welfare wf on wf.welfareId = wfd.welfareId
                where wfc.fieldMap = :fieldmap
                and wfc.valuex in 
                ( 
                   select employeeTypeId from v_fullmember where memberId =:memberId
                )
                and wfd.statusActive = 'Y' and wf.statusActive = 'Y' ";

        $param = array("memberId" => $memberId, "fieldmap" => "employeeTypeId");
        $details = $this->datacontext->pdoQuery($sqlDetails, $param);

        $matchId = array();
        foreach ($details as $valueId) {
            $condition = new \apps\welfare\entity\Conditions();
            $condition->detailsId = $valueId['detailsId'];
            $dataCondition = $this->datacontext->getObject($condition);

            $query = "SELECT * "
                    . "FROM v_fullmember "
                    . "where ";
            $field = array();
            foreach ($dataCondition as $key => $value) {
                $index = 0;
                if (!empty($field[$value->fieldMap])) {
                    $index = count($field[$value->fieldMap]);
                }
                $field[$value->fieldMap][$index]['operations'] = $value->operations;
                $field[$value->fieldMap][$index]['valuex'] = $value->valuex;
            }

            $where = "";
            foreach ($field as $key => $value) {
                $count = count($value);
                $sql = "";
                if ($where != "") {
                    $sql .= " AND ";
                }
                if ($count > 1 && $key == 0) {
                    $sql .= " ( ";
                }

                foreach ($value as $key2 => $value2) {

                    if ($sql != "" && $key2 > 0) {
                        if ($value2['operations'] == "=" || $value2['operations'] == "!=") {
                            $sql .= " OR ";
                        } else {
                            $sql .= " AND ";
                        }
                    }
                    if (strpos($value2['valuex'], "-") && ($key == "dob" || $key == "workStartDate" || $key == "workEndDate")) {
                        $sql .= " " . $key . " " . $value2['operations'] . " '" . $value2['valuex'] . "' ";
                    } elseif (!strpos($value2['valuex'], "-") && ($key == "dob" || $key == "workStartDate" || $key == "workEndDate")) {
                        $sql .= " TIMESTAMPDIFF(YEAR,'" . $member->$key . "', CURDATE()) " . $value2['operations'] . " " . $value2['valuex'] . " ";
                    } else {
                        $sql .= " " . $key . " " . $value2['operations'] . " '" . $value2['valuex'] . "' ";
                    }
                }
                if ($count > 1) {
                    $sql .= " ) ";
                }
                $where .= $sql;
            }
            $detailsId = $valueId['detailsId'];
            $sql = $query . " " . $where . " and memberId = :memberId ";
            $dataCheck = $this->datacontext->pdoQuery($sql, array("memberId" => $memberId));
            if (count($dataCheck) > 0) {
                array_push($matchId, $detailsId);
            }
        }

        $id = "";
        foreach ($matchId as $key => $value) {
            if ($key != 0) {
                $id .= "," . $value;
            } else {
                $id .= $value;
            }
        }

        $sqlDetails = "SELECT wfdt.detailsId as detailsId,wfdt.quantity,wfdt.returnTypeId,wfdt.description as dcpDetails , "
                . "wfdt.welfareId,  "
                . "rt.value1 As returntType,rt.id,"
                . "wf.name,wf.statusActive,wf.description  "
                . " FROM  welfaredetails wfdt "
                . "Left JOIN  welfare wf "
                . "on wfdt.welfareId = wf.welfareId "
                . "Left JOIN taxonomy rt  "
                . "on wfdt.returnTypeId = rt.id "
                . "where detailsId in ( " . $id . " )";


        $objDetailsId = $this->datacontext->pdoQuery($sqlDetails);


        $sqlHistory = "SELECT htr.historyId,htr.detailsId,htr.statusApprove "
                . "From welfarehistory htr where detailsId in (" . $id . ") and memberId=:memberId Order By htr.historyId desc ";

        $param1 = array("memberId" => $memberId);

        $objHistory = $this->datacontext->pdoQuery($sqlHistory, $param1);

        if (!empty($objHistory)) {
            foreach ($objHistory as $key => $value) {
                if($value["statusApprove"]=="Y"){
                    $objDetailsId[$key]['statusApprove'] = "อนุมัติแล้ว";
                }else{
                    $objDetailsId[$key]['statusApprove'] = "รอดำเนินการ";
                }
                
                $objDetailsId[$key]['historyId'] = $value["historyId"];
            }
        }

       





        $f = fopen('php://memory', 'w');

        fputs($f, iconv("UTF-8", "windows-874", " ,," . "รายงานบุคลากร" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "รหัสบัตรประชาชน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "คำนำหน้า" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "นามสกุล" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "หน่วยงานที่สังกัด" . "\"\r\n"));


        fputs($f, iconv("UTF-8", "windows-874", "\"'" . $member->idCard . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . $member->titles1 . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . $member->fname . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . $member->lname . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . $member->department1 . "" . $member->faculty1 . "\"\r\n"));

        fputs($f, iconv("UTF-8", "windows-874", " ,," . "" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", " ,," . "รายงานการใช้สวัสดิการ" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อสวัสดิการ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "รายละเอียดเงื่อนไข" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "จำนวน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "รายการใช้สวัสดิการ" . "\"\r\n"));

        foreach ($objDetailsId as $key => $value) {
            fputs($f, iconv("UTF-8", "windows-874", "\"'" . $value['name'] . "" . $value['description'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['dcpDetails'] . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['quantity'] . "" . $value['returntType'] . "\","));
            //fputs($f, iconv("UTF-8", "windows-874", "\"" . $value['statusApprove'] . "\"\r\n"));
        }

        // $newFields = array(
        //   array($value->idCard, utf8_encode($value->fname), $value->lname));
        // fputcsv($f, $objMember);

        fseek($f, 0);
        header('Content-Type: application/csv; charset=windows-874');
        header('Content-Disposition: attachment; filename="report_right.csv";');
        fpassthru($f);
        exit();
    }

    public function reportCsvWelfare() {
        
          $where = "select w.welfareId,
                count(cm.countMember) as countMember,
                cu.countUse from welfare w 
                join (
                select
                welfareId,
                memberId as countMember
                from welfarehistory group by welfareId,memberId
                ) cm on w.welfareId = cm.welfareId
                join (
                select
                welfareId,
                count(memberId) as countUse
                from welfarehistory group by welfareId
                ) cu on w.welfareId = cu.welfareId
                group by w.welfareId,w.name";
        $obj = $this->datacontext->pdoQuery($where);
        
        $dao = new WelfareService();
        
        $count = array();
        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->statusActive = "Y";
        $wf = $this->datacontext->getObject($welfare);
        foreach ($wf as $keyWf => $valWf) {
            $count[$valWf->welfareId] = 0;
            $detail = new \apps\welfare\entity\Details();
            $detail->welfareId = $valWf->welfareId;
            $wd = $this->datacontext->getObject($detail);
            foreach ($wd as $keyWd => $valWd) {
                $cond = new \apps\welfare\entity\Conditions();
                $cond->detailsId = $valWd->detailsId;
                $wc = $this->datacontext->getObject($cond);
                if (count($wc) > 0) {
                    $mb = $dao->preview($wc);
                    $count[$valWf->welfareId] += count($mb);
                }
            }
        }



        foreach ($wf as $key => $value) {

            if ($value->resetTime == "12") {
                $value->resetTime = "ทุก 1 ปี";
            } elseif ($value->resetTime == "0") {
                $value->resetTime = "ครั้งเดียว";
            } elseif ($value->resetTime == "6") {
                $value->resetTime = "ทุก 6 เดือน";
            }

            foreach ($count as $key1 => $value1) {
                if ($value->welfareId == $key1) {
                    $wf[$key]->totals = $value1;
                }
            }
            
            $wf[$key]->dateStart = date_format($value->dateStart, "Y-m-d");
            if($value->dateEnd!=""){
            $wf[$key]->dateEnd = date_format($value->dateEnd, "Y-m-d");
            }
            $wf[$key]->countMember = "";
            $wf[$key]->countUse = "";

            foreach ($obj as $keyobj => $valueobj) {

                if ($value->welfareId == $obj[$keyobj]['welfareId']) {
                    $wf[$key]->countMember = $valueobj['countMember'];
                    $wf[$key]->countUse = $valueobj['countUse'];
                }
            }
        }
        
         $f = fopen('php://memory', 'w');

        fputs($f, iconv("UTF-8", "windows-874", " ,," . "" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", " ,," . "รายงานการใช้สวัสดิการ" . ",,\r\n"));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ชื่อสวัสดิการ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "วันที่เริ่ม" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "วันที่สิ้นสุด" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "สิทธิ์สวัสดิการ" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "จำนวนผู้ได้รับสิทธิ์" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "จำนวนผู้ใช้สินทธิ์" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "ใช้แล้วจำนวน" . "\","));
        fputs($f, iconv("UTF-8", "windows-874", "\"" . "สิทธิ์สวัสดิการ" . "\"\r\n"));
        
        foreach ($wf as $key => $value) {
          
            fputs($f, iconv("UTF-8", "windows-874", "\"'" . $value->name . "" . $value->description . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value->dateStart . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value->dateEnd . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value->resetTime . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value->totals . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value->countMember . "\","));
            fputs($f, iconv("UTF-8", "windows-874", "\"" . $value->countUse . "\"\r\n"));
        }

        // $newFields = array(
        //   array($value->idCard, utf8_encode($value->fname), $value->lname));
        // fputcsv($f, $objMember);

        fseek($f, 0);
        header('Content-Type: application/csv; charset=windows-874');
        header('Content-Disposition: attachment; filename="report_welfare.csv";');
        fpassthru($f);
        exit();
        
    }

}
