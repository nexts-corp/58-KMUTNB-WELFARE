<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;
use apps\welfare\interfaces\IWelfareService;
use apps\common\service\CommonService;
use apps\welfare\entity\Welfare;
use apps\welfare\entity\Details;
use apps\welfare\entity\Conditions;
use apps\taxonomy\entity\Taxonomy;

class WelfareService extends CServiceBase implements IWelfareService {

    public $datacontext;
    public $common;

    public function __construct() {
        $this->datacontext = new CDataContext(NULL);
        $this->common = new CommonService();
        $this->pathMember = "apps\\member\\model\\";
    }

    public function save($welfare) {

        $json = new CJSONDecodeImpl();
        $details = $json->decode(new Details(), $this->getRequest()->data2->welfare, "details");
        unset($welfare->details);
        if ($welfare->dateStart != "") {
            $welfare->dateStart = $this->common->str2date($welfare->dateStart, "d-m-Y", "-");
        }
        if ($welfare->dateEnd != "") {
            $welfare->dateEnd = $this->common->str2date($welfare->dateEnd, "d-m-Y", "-");
        }
        if ($this->datacontext->saveObject($welfare)) {
            $welfareId = $welfare->welfareId;
            foreach ($details as $key => $value) {
                $value->welfareId = $welfareId;
                $conditions = $json->decode(new Conditions(), $value, "conditions");
                unset($value->conditions);
                $this->datacontext->saveObject($value);
                $detailsId = $value->detailsId;
                foreach ($conditions as $key2 => $value2) {
                    $value2->welfareId = $welfareId;
                    $value2->detailsId = $detailsId;
                    $this->datacontext->saveObject($value2);
                }
            }
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function update($welfare) {
        $welfareId = $welfare->welfareId;
        $json = new CJSONDecodeImpl();
        $details = $json->decode(new Details(), $this->getRequest()->data2->welfare, "details");
        unset($welfare->details);

        if ($welfare->dateStart != "") {
            $welfare->dateStart = $this->common->str2date($welfare->dateStart, "d-m-Y", "-");
        }
        if ($welfare->dateEnd != "") {
            $welfare->dateEnd = $this->common->str2date($welfare->dateEnd, "d-m-Y", "-");
        }
        if ($this->datacontext->updateObject($welfare)) {
            foreach ($details as $key => $value) {
                if (empty($value->detailsId)) {
                    $value->welfareId = $welfareId; //set welfareId for details
                    $conditions = $json->decode(new Conditions(), $value, "conditions"); //convert class conditions
                    unset($value->conditions); // delete object condition from details

                    $this->datacontext->saveObject($value); //save details
                    $detailsId = $value->detailsId; //set detailsId

                    foreach ($conditions as $key2 => $value2) {
                        $value2->welfareId = $welfareId;
                        $value2->detailsId = $detailsId;
                        $this->datacontext->saveObject($value2);
                    }
                } else {
                    $detailsId = $value->detailsId;
                    $conditions = $json->decode(new Conditions(), $value, "conditions");
                    unset($value->conditions);
                    $this->datacontext->updateObject($value);
                }
            }
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function delete($id) {
        $daoWelfare = new Welfare();
        $daoWelfare->setWelfareId($id);
        $daoWelfare->setStatusActive('N');

        if ($this->datacontext->updateObject($daoWelfare)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function get($welfareId) {
        $welfare = new Welfare();
        $welfare->welfareId = $welfareId;
        $welfare = $this->datacontext->getObject($welfare)[0];
        $welfare = $this->common->afterGet($welfare, array("dateCreated", "dateUpdated", "createBy", "updateBy"));
        $details = new Details();
        $details->welfareId = $welfareId;
        $details = $this->datacontext->getObject($details);
        foreach ($details as $key => $object) {
            $conditions = new Conditions();
            $conditions->detailsId = $object->detailsId;
            $conditions = $this->datacontext->getObject($conditions);
            $conditions = $this->common->afterGet($conditions, array("welfareId", "detailsId", "dateCreated", "dateUpdated", "createBy", "updateBy"));
            $details[$key]->conditions = $conditions;
        }
        $details = $this->common->afterGet($details, array("welfareId", "dateCreated", "dateUpdated", "createBy", "updateBy"));
        $welfare->details = $details;
        return $welfare;
    }

    public function preview($conditions) {
        //ตรวจสอบว่าเงื่อนไข ตรงกับบุคลากรไหนบ้าง


        $query = "SELECT *,IFNULL(academic1,titleName1) title "
                . "FROM v_fullmember "
                . "where ";

        $field = array();
        foreach ($conditions as $key => $value) {
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
                    $sql .= " " . $key . " " . $value2['operations'] . " " . $value2['valuex'] . " ";
                } elseif (!strpos($value2['valuex'], "-") && ($key == "dob" || $key == "workStartDate" || $key == "workEndDate")) {
                    $sql .= " TIMESTAMPDIFF(YEAR," . $key . ", CURDATE()) " . $value2['operations'] . " " . $value2['valuex'] . " ";
                } else {
                    $sql .= " " . $key . " " . $value2['operations'] . " " . $value2['valuex'] . " ";
                }
            }
            if ($count > 1) {
                $sql .= " ) ";
            }
            $where .= $sql;
        }

        $sql = $query . $where;

        $member = $this->datacontext->pdoQuery($sql);




        return $member;
    }

    public function checkWelfare() {

        $memberId = $this->getRequest()->memberId;
        $mb = new \apps\member\service\MemberService();
        $member = $mb->find("memberId", $memberId)[0];
//        $employeeTypeId = $member->employeeTypeId;

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
                . "where wf.statusActive='Y' and detailsId in ( " . $id . " )";


        $objDetailsId = $this->datacontext->pdoQuery($sqlDetails);


        $sqlHistory = "SELECT htr.historyId,htr.detailsId,htr.statusApprove "
                . "From welfarehistory htr where detailsId in (" . $id . ") and memberId=:memberId ";

        $param1 = array("memberId" => $memberId);

        $objHistory = $this->datacontext->pdoQuery($sqlHistory, $param1);



        if (!empty($objHistory)) {
            foreach ($objDetailsId as $key => $value) {
                $objDetailsId[$key]['statusApprove'] = "";
                $objDetailsId[$key]['historyId'] = "";
                foreach ($objHistory as $key1 => $value1) {
                    if ($key['detailsId'] == $key1['detailsId']) {
                        $objDetailsId[$key]['statusApprove'] = $value1["statusApprove"];
                        $objDetailsId[$key]['historyId'] = $value1["historyId"];
                    }
                }
            }
        }

        if ($objDetailsId != "") {
            return $objDetailsId;
        } else {
            return false;
        }
    }

    public function byWelfare($data) {

//        $welfaredao = new Welfare();
//        $welfaredao->welfareId = $data->welfareId;
//        $objwelfare = $this->datacontext->getObject($welfaredao);
//        $objwelfare = $this->common->afterGet($objwelfare, array("dateCreated", "dateUpdated", "createBy", "updateBy"));
//        
//        $sqlDetails = "SELECT wfdt.detailsId as detailsId,wfdt.quantity,wfdt.returnTypeId,wfdt.description as dcpDetails , "
//                . "wfdt.welfareId,  "
//                . "rt.value1 As returntType,rt.id,"
//                . "wf.name,wf.statusActive,wf.description  "
//                . " FROM  welfaredetails wfdt "
//                . "Left JOIN  welfare wf "
//                . "on wfdt.welfareId = wf.welfareId "
//                . "Left JOIN taxonomy rt  "
//                . "on wfdt.returnTypeId = rt.id "
//                . "where wfdt.detailsId=:detailsId";
        /*
          $sqlDetails = "SELECT hr.detailsId,hr.remark,hr.amount,hr.dateUse ,"
          . "wfdt.detailsId ,wfdt.quantity,wfdt.returnTypeId,wfdt.description as dcpDetails , "
          . "wf.welfareId,wf.name,  "
          . "rt.value1 As returntType,rt.id,"
          . "wf.name,wf.statusActive,wf.description  "
          . " FROM  welfarehistory hr "
          . "left join welfare wf "
          . "on hr.welfareId=wf.welfareId "
          . "left join welfaredetails wfdt "
          . "on hr.detailsId = wfdt.detailsId "
          . "left join taxonomy rt "
          . "on wfdt.returnTypeId = rt.id "
          . "where hr.hr.detailsId=:detailsId and memberId=:memberId  ";
          $param = array("detailsId" => $data->detailsId, "memberId" => $data->memberId);
         */

        $sqlDetails = "select 
            welhist.detailsId as detailsId, welhist.memberId,
            welhist.amount as amount, welhist.dateUse as dateUse, welhist.remark as remark,
            concat(welcon.operations, ' ', welcon.valuex) as dcpDetails,
            weldel.description as description,
            weldel.quantity as quantity,
            weldel.returnTypeId, rettype.value1 as returntType,
            wel.welfareId as welfareId, wel.`name` as name,
            wel.statusActive
            from welfarehistory welhist
            inner join welfare wel on wel.welfareId = welhist.welfareId
            inner join welfaredetails weldel on weldel.welfareId = wel.welfareId
            inner join welfareconditions welcon on welcon.welfareId = wel.welfareId
            inner join taxonomy rettype on rettype.id = weldel.returnTypeId
            where welhist.dateUse is not null and welhist.memberId = :memberId";
        $param = array("memberId" => $data->memberId);

        $objdetails = $this->datacontext->pdoQuery($sqlDetails, $param);

        return $objdetails;
    }

    public function searchWelfare($data) {


        if ($data->dateStart != "" or $data->dateEnd != "" or $data->searchName != "") {
            $where = "";



            if ($data->dateStart != "" && $data->dateEnd == "") {
                $arrdateStart = explode("-", $data->dateStart);
                $year = $arrdateStart[2] - "543";
                $dateStart = $year . "-" . $arrdateStart[1] . "-" . $arrdateStart[0];



                $where .="And wf.dateStart >= '" . $dateStart . "'";
            } elseif ($data->dateStart == "" && $data->dateEnd != "") {

                $arrdateEnd = explode("-", $data->dateEnd);
                $year = $arrdateEnd[2] - "543";
                $dateEnd = $year . "-" . $arrdateEnd[1] . "-" . $arrdateEnd[0];

                $where .="And wf.dateEnd <= '" . $dateEnd . "'";
            } elseif ($data->dateStart != "" && $data->dateEnd != "") {

                $arrdateStart = explode("-", $data->dateStart);
                $year = $arrdateStart[2] - "543";
                $dateStart = $year . "-" . $arrdateStart[1] . "-" . $arrdateStart[0];

                $arrdateEnd = explode("-", $data->dateEnd);
                $year = $arrdateEnd[2] - "543";
                $dateEnd = $year . "-" . $arrdateEnd[1] . "-" . $arrdateEnd[0];

                $where .="And wf.dateStart >= '" . $dateStart . "' And  wf.dateEnd <= '" . $dateEnd . "'";
            }
            if ($data->searchName) {
                $where .="And wf.name LIKE '%" . $data->searchName . "%'";
            }



            $sqlWelfare = "SELECT wf.welfareId,wf.name,wf.statusActive,wf.resetTime,wf.free , "
                    . "wf.willing,wf.dateStart,wf.dateEnd "
                    . " FROM welfare wf where wf.statusActive='Y' " . $where . " ";
            $obj = $this->datacontext->pdoQuery($sqlWelfare);

            foreach ($obj as $key => $value) {

                if ($obj[$key]['resetTime'] == "12") {
                    $obj[$key]['resetTime'] = "ทุก 1 ปี";
                } elseif ($obj[$key]['resetTime'] == "0") {
                    $obj[$key]['resetTime'] = "ครั้งเดียว";
                } elseif ($obj[$key]['resetTime'] == "6") {
                    $obj[$key]['resetTime'] = "ทุก 6 เดือน";
                }
            }

            return $obj;
        } else {

            $daoWelfare = new Welfare();

            $obj = $this->datacontext->getObject($daoWelfare);
            $obj = $this->common->afterGet($obj);

            foreach ($obj as $key => $value) {

                if ($obj[$key]->resetTime == "12") {
                    $obj[$key]->resetTime = "ทุก 1 ปี";
                } elseif ($obj[$key]->resetTime == "0") {
                    $obj[$key]->resetTime = "ครั้งเดียว";
                } elseif ($obj[$key]->resetTime == "6") {
                    $obj[$key]->resetTime = "ทุก 6 เดือน";
                }
            }


            return $obj;
        }
    }

    public function pdfWelfare() {


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
                    $mb = $this->preview($wc);
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
            if ($value->dateEnd != "") {
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


        return $wf;
    }

    public function rightMember($data) {

        $where = "";
        $checkWhere = "";
        if ($data != "") {

            if ($data->faculty != "" or $data->department != "" or $data->employeeType != "" or $data->gender != "" or $data->searchName != "") {
                $checkWhere .= "where";
            }


            if ($data->faculty != "") {
                if ($where != "") {
                    $where .= " and ";
                }
                $where .="  mb.facultyId='" . $data->faculty . "'";
            } else {
                $where .="";
            }
            if ($data->department != "") {
                if ($where != "") {
                    $where .= " and ";
                }
                $where .="  mb.departmentId='" . $data->department . "'";
            } else {
                $where .="";
            }
            if ($data->employeeType != "") {
                if ($where != "") {
                    $where .= " and ";
                }
                $where .=" mb.employeeTypeId='" . $data->employeeType . "'";
            } else {
                $where .="";
            }
            if ($data->gender != "") {
                if ($where != "") {
                    $where .= " and ";
                }
                $where .=" mb.genderId='" . $data->gender . "'";
            } else {
                $where .="";
            }
            if ($data->searchName != "") {
                if ($where != "") {
                    $where .= " and ";
                }
                $where .=" mb.fname LIKE '%" . $data->searchName . "%' or mb.lname LIKE '%" . $data->searchName . "%'";
            } else {
                $where .="";
            }
        }

        $query = "SELECT mb "
                . "FROM apps\\member\\model\\Fullmember mb " . $checkWhere . " " . $where;


        $member = $this->datacontext->getObject($query);

        return $member;
    }

    public function getMemPreview($conditions) {
        $query = "SELECT *,IFNULL(academic1,titleName1) title "
                . "FROM v_fullmember "
                . "where ";

        $field = array();
        foreach ($conditions as $key => $value) {
            $index = 0;
            if (!empty($field[$value['fieldMap']])) {
                $index = count($field[$value['fieldMap']]);
            }
            $field[$value['fieldMap']][$index]['operations'] = $value['operations'];
            $field[$value['fieldMap']][$index]['valuex'] = $value['valuex'];
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
                    $sql .= " " . $key . " " . $value2['operations'] . " " . $value2['valuex'] . " ";
                } elseif (!strpos($value2['valuex'], "-") && ($key == "dob" || $key == "workStartDate" || $key == "workEndDate")) {
                    $sql .= " TIMESTAMPDIFF(YEAR," . $key . ", CURDATE()) " . $value2['operations'] . " " . $value2['valuex'] . " ";
                } else {
                    $sql .= " " . $key . " " . $value2['operations'] . " " . $value2['valuex'] . " ";
                }
            }
            if ($count > 1) {
                $sql .= " ) ";
            }
            $where .= $sql;
        }

        $sql = $query . $where;

        $member = $this->datacontext->pdoQuery($sql);
        return $member;
    }

    public function getRightWelfare($data) {

        $welfareId = $data->welfareId;
        $daoWelfare = new WelfareService();
        $objWelfare = $daoWelfare->get($welfareId);
        $employee = array();

        foreach ($objWelfare->details as $key => $value) {

            array_push($employee, $daoWelfare->preview($value->conditions));
        }


        $member = array();
        foreach ($employee as $key => $value) {

            foreach ($value as $key1 => $value1) {
                array_push($member, $value1);
            }
        }

        return $member;
    }

    public function getMemberDetails($data) {

        $conditions = new Conditions();
        $conditions->detailsId = $data->detailsId;
        $conditions = $this->datacontext->getObject($conditions);
        $conditions = $this->common->afterGet($conditions, array("welfareId", "detailsId", "dateCreated", "dateUpdated", "createBy", "updateBy"));


        $daoWelfare = new WelfareService();
        $objMember = $daoWelfare->preview($conditions);

        if ($objMember != "") {
            return $objMember;
        } else {
            return false;
        }
    }

    public function searchMemberDetails($data) {

        $welfareId = $data->welfareId;
        $sql = "";

        if ($data->idCard != "") {
            $sql .=" mb.idCard=" . $data->idCard . "";
        }

        if ($data->fname != "" and $data->lname != "") {
            if ($sql != "") {
                $or = "or";
            } else {
                $or = "";
            }

            $sql .=" " . $or . "  mb.fname Like '%" . $data->fname . "%' "
                    . " or mb.lname Like '%" . $data->lname . "%' ";
        }

        $query = "SELECT mb "
                . " FROM " . $this->pathMember . "Fullmember mb where  " . $sql . "";



        $member = $this->datacontext->getObject($query)[0];

        $memberId = $member->memberId;

        $sqlDetails = "select wfc.detailsId  from welfareconditions wfc
                join welfaredetails wfd on wfc.detailsId = wfd.detailsId
                join welfare wf on wf.welfareId = wfd.welfareId
                where  wf.welfareId=:welfareId ";

        $param = array("welfareId" => $data->welfareId);
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
                . "where wf.statusActive='Y' and detailsId in (" . $id . ")";


        $objDetailsId = $this->datacontext->pdoQuery($sqlDetails);

        if ($objDetailsId != "") {
            foreach ($objDetailsId as $key => $value) {
                $member->detailsId = $value['detailsId'];
            }
        }

        if ($member != "") {
            return $member;
        } else {
            return FALSE;
        }
    }

}
