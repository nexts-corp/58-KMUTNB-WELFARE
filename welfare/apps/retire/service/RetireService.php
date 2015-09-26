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
        
        

//        exit();
//        if ($retireYear == "") {
//            $retireYear = date("Y");
//        
//        } 
//        elseif ($retireYear->) {
//            
//        }



        $query1 = "select tax.id "
                . "from taxonomy tax  "
                . "where tax.code = 'employee' and tax.pCode = 'employeeType' ";
        $welfare = $this->datacontext->pdoQuery($query1);
        $employeeTypeId = $welfare[0]['id'];

        $query = "select mb.memberId,ifnull(mb.academic1,mb.titleName1) as titleName,mb.fname,mb.lname,mb.department1, "
                . "mb.faculty1,mb.dob,mb.workStartDate,TIMESTAMPDIFF(YEAR,mb.workStartDate,curdate()) as ageWork, "
                . "welEmp.employeeTypeId,mb.employeeType1,welEmp.quantity,welStart.workStartDate,welEnd.workEndDate,sum(welEmp.quantity) as total "
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
        if ($retireYear->present != "") {
            print_r($retireYear->present);
            $retire = $retireYear->present;
            $retireStart = ($retire - 61) . "-10-01";
            $retireEnd = ($retire - 60) . "-09-30";
            $retireY = $retire . "-09-30";

            $param = array(
                "retireStart" => $retireStart,
                "retireEnd" => $retireEnd,
                "retireyear" => $retireY,
                "employeeTypeIds" => $employeeTypeId
            );
        } else if ($retireYear->searchName != "") {
            
            $searchName = $retireYear->searchName;
            $retire = $retireYear->retire;
            $retireStart = ($retire - 61) . "-10-01";
            $retireEnd = ($retire - 60) . "-09-30";
            $retireY = $retire . "-09-30";
            
            $query .= "and mb.fname LIKE :name or mb.lname LIKE :name or mb.idCard LIKE :name ";
            $param = array(
                "name" => "%" . $searchName . "%",
                "retireStart" => $retireStart,
                "retireEnd" => $retireEnd,
                "retireyear" => $retireY,
                "employeeTypeIds" => $employeeTypeId
            );
        } else if ($retireYear->retire != "") {
            $retire = $retireYear->retire;
            $retireStart = ($retire - 61) . "-10-01";
            $retireEnd = ($retire - 60) . "-09-30";
            $retireY = $retire . "-09-30";

            $param = array(
                "retireStart" => $retireStart,
                "retireEnd" => $retireEnd,
                "retireyear" => $retireY,
                "employeeTypeIds" => $employeeTypeId
            );
        } else {
            $filtercode = $retireYear->filterCode;
            $filtervalue = $retireYear->filtervalue;
            $retire = $retireYear->date;
            $retireStart = ($retire - 61) . "-10-01";
            $retireEnd = ($retire - 60) . "-09-30";
            $retireY = $retire . "-09-30";
            
            $query .= " and mb." . $filtercode . "Id = :filtervalue  ";

            $param = array(
                "filtervalue" => $filtervalue,
                "retireStart" => $retireStart,
                "retireEnd" => $retireEnd,
                "retireyear" => $retireY,
                "employeeTypeIds" => $employeeTypeId
            );
        }

//        $param = array(
//            "retireStart" => $retireStart,
//            "retireEnd" => $retireEnd,
//            "retireyear" => $retireY,
//            "employeeTypeIds" => $employeeTypeId
//        );

        $member = $this->datacontext->pdoQuery($query, $param);


        return $member;
    }

}
