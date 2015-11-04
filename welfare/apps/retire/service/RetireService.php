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
//        print_r($retireYear->filterCode);
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
                . "and TIMESTAMPDIFF(YEAR,mb.workStartDate,:retireyear) < welEnd.workEndDate ";

        $query2 = "select sum(welEmp.quantity) as total "
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

        if ($retireYear->present != "") {
            
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
            $query2 .= "and mb.fname LIKE :name or mb.lname LIKE :name or mb.idCard LIKE :name ";
            $param = array(
                "name" => "%" . $searchName . "%",
                "retireStart" => $retireStart,
                "retireEnd" => $retireEnd,
                "retireyear" => $retireY,
                "employeeTypeIds" => $employeeTypeId
            );
        } else if ($retireYear->filterCode != "") {
            
            $filtercode = $retireYear->filterCode;
            $filtervalue = $retireYear->filtervalue;
            $retire = $retireYear->retire;
            $retireStart = ($retire - 61) . "-10-01";
            $retireEnd = ($retire - 60) . "-09-30";
            $retireY = $retire . "-09-30";

            $query .= " and mb." . $filtercode . "Id = :filtervalue  ";
            $query2 .= " and mb." . $filtercode . "Id = :filtervalue  ";
            $param = array(
                "filtervalue" => $filtervalue,
                "retireStart" => $retireStart,
                "retireEnd" => $retireEnd,
                "retireyear" => $retireY,
                "employeeTypeIds" => $employeeTypeId
            );
        } else {
            
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
        }

//        $param = array(
//            "retireStart" => $retireStart,
//            "retireEnd" => $retireEnd,
//            "retireyear" => $retireY,
//            "employeeTypeIds" => $employeeTypeId
//        );

        $member = $this->datacontext->pdoQuery($query, $param);
        $total = $this->datacontext->pdoQuery($query2, $param)[0];


        if ($total['total'] != "") {
            $total['total'] = number_format($total['total']);
        }


        foreach ($member as $key => $value) {

            if ($member[$key]['quantity'] != "") {
                $member[$key]['quantity'] = number_format($member[$key]['quantity']);
            }
//                if ($member[$key]['total'] != "") {
//                    $member[$key]['total'] = number_format($member[$key]['total']);
//                }
        }
        return array("member" => $member, "total" => $total);
    }

}
