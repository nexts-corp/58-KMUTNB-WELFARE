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
        $query1 = "select tax.id "
                . "from welfare wel "
                . "join welfaredetails wd "
                . "on wd.welfareId = wel.welfareId and wel.code = 'retire001' "
                . "join welfareconditions wc  "
                . "on wc.detailsId = wd.detailsId and wc.fieldMap = 'employeeTypeId' "
                . "join taxonomy tax "
                . "on tax.id = wc.valuex and tax.code = 'employee'";
        $welfare = $this->datacontext->pdoQuery($query1);
       $employeeTypeId = $welfare[0]['id'];
        

        // กำลัง หาวิธี ดึง ชื่อ ผู้ เกษียน ขึ้นมาแสดง ยุ 
        
        $retireStart = ($retireYear - 61) . "-10-01";
        $retireEnd = ($retireYear - 60) . "-09-30";
        $retireY = $retireYear. "-09-30";
        
        $query = "select mb.memberId,ifnull(mb.academic1,mb.titleName1) as titleName,mb.fname,mb.lname,mb.department1, "
                . "mb.faculty1,mb.dob,mb.workStartDate,TIMESTAMPDIFF(YEAR,mb.workStartDate,curdate()) as ageWork, "
                . "welEmp.employeeTypeId,mb.employeeType1,welEmp.quantity,welStart.workStartDate,welEnd.workEndDate "
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
                . "and TIMESTAMPDIFF(YEAR,mb.workStartDate,:retireyear) < welEnd.workEndDate; ";
//                
//        $query = "SELECT mb.fname,mb.lname,mb.employeeTypeId,mb.titleNameId,mb.genderId,mb.dob,mb.workStartDate,mb.workEndDate , mb.facultyId , "
//                . "mb.departmentId,weld.description,weld.ageWorkStart,weld.ageWorkEnd ,:retireyear-YEAR(mb.workStartDate) as ry,weld.quantity, "
//                . "IFNULL(academic.value1,title.value1) title, " //IFNULL(value1,value2) select ถ้ามีค่าใดค่าหนึ่ง ,ถ้ามีค่าทั้งคู่จะ select value1 ออกมา 
//                . "(employeeType.value1) As employeeType, "
//                . "(gender.value1) As gender, "
//                . "(faculty.value1) As faculty, "
//                . "(department.value1) As department "
//                . "FROM v_member mb "
//                . "Left JOIN taxonomy title "
//                . "on mb.titleNameId = title.id "
//                . "Left JOIN taxonomy academic "
//                . "on mb.academicId = academic.id "
//                . "Left JOIN taxonomy employeeType "
//                . "on mb.employeeTypeId = employeeType.id "
//                . "Left JOIN taxonomy gender "
//                . "on mb.genderId = gender.id "
//                . "Left JOIN taxonomy faculty "
//                . "on mb.facultyId = faculty.id "
//                . "Left JOIN taxonomy department "
//                . "on mb.departmentId = department.id "
//                . "inner join welfaredetails weld "
//                . "inner join welfare wel "
//                . "on wel.welfareId = welc.welfareId  "
//                . "where retire = 'Y' and wel.code = 'retire001' "
//                . "and mb.dob between :retireStart and :retireEnd "
//                . "and weld.ageWorkStart <= :retireyear-YEAR(mb.workStartDate) "
//                . "and :retireyear-YEAR(mb.workStartDate) <= weld.ageWorkEnd";
        $param = array(
            "retireStart" => $retireStart,
            "retireEnd" => $retireEnd,
            "retireyear" => $retireY,
            "employeeTypeIds"=>$employeeTypeId
        );
//        print_r($query);
        $member = $this->datacontext->pdoQuery($query, $param);
        
//        $i=0;
//        foreach ($member as $key => $value) {
//            if ($value['amount'] != "") {
//               //$member[$key]['total'] = $value['amount'] ;
//                $num = $i += $member[$key]['total'] = $value['amount'];
//            } else {
//                break;
//            }
//        }
        //$member->countTotal=$num;
        return $member;
    }

}
