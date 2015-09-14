<?php

namespace apps\retire\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\retire\interfaces\IRetireService;

class RetireService extends CServiceBase implements IRetireService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function preview($retireYear) {
//        $retireYear -= 543;
        if ($retireYear == "") {
            $retireYear = date("Y");
            print_r($retireYear); 
        }
        // กำลัง หาวิธี ดึง ชื่อ ผู้ เกษียน ขึ้นมาแสดง ยุ 
        $retireStart = ($retireYear - 61) . "-10-01";
        $retireEnd = ($retireYear - 60) . "-09-30";
        $query = "SELECT mb.fname,mb.lname,mb.employeeTypeId,mb.titleId,mb.genderId,mb.dob,mb.workStartDate,mb.workEndDate , mb.facultyId , "
                . "mb.departmentId,welc.description,welc.ageWorkStart,welc.ageWorkEnd ,:retireyear-YEAR(mb.workStartDate) as ry,welc.amount, "
//                . "(title.value1) As title, "
//                . "(academic.value1) As academic,"
                . "IFNULL(academic.value1,title.value1) title, " //IFNULL(value1,value2) select ถ้ามีค่าใดค่าหนึ่ง ,ถ้ามีค่าทั้งคู่จะ select value1 ออกมา 
                . "(employeeType.value1) As employeeType, "
                . "(gender.value1) As gender, "
                . "(faculty.value1) As faculty, "
                . "(department.value1) As department "
                . "FROM member mb "
                . "Left JOIN taxonomy title "
                . "on mb.titleId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mb.academicId = academic.id "
                . "Left JOIN taxonomy employeeType "
                . "on mb.employeeTypeId = employeeType.id "
                . "Left JOIN taxonomy gender "
                . "on mb.genderId = gender.id "
                . "Left JOIN taxonomy faculty "
                . "on mb.facultyId = faculty.id "
                . "Left JOIN taxonomy department "
                . "on mb.departmentId = department.id "
                . "inner join welfareconditions welc "
                . "inner join welfare wel "
                . "on wel.welfareId = welc.welfareId  "
                . "where retire = 'Y' and wel.code = 'retire001' "
                . "and mb.dob between :retireStart and :retireEnd "
                . "and welc.ageWorkStart <= :retireyear-YEAR(mb.workStartDate) "
                . "and :retireyear-YEAR(mb.workStartDate) <= welc.ageWorkEnd";
        $param = array(
            "retireStart" => $retireStart,
            "retireEnd" => $retireEnd,
            "retireyear"=> $retireYear
        );
//        print_r($query);
        $member = $this->datacontext->pdoQuery($query, $param);
        return $member;
    }

}
