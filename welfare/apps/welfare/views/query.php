<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of query
 *
 * @author tawatchai
 */
class query {

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

    public function byMemberWfLists($data) {
        //หาสวัสดิการว่าตัวเองเข้าเงื่อนไขสวัสดิการอะไรบ้าง
        $view = new CJView("byMember/wfLists", CJViewType::HTML_VIEW_ENGINE);

        $memberId = $data->memberId;
        $mb = new \apps\member\service\MemberService();
        $member = $mb->find("memberId", $memberId)[0];
        $employeeTypeId = $data->fieldMap;

        $parthWelfare = '\\apps\\welfare\\entity\\';



        $sqlDetails = "select detailsId
                              from welfareconditions where fieldMap = :fieldmap and valuex in 
                                   ( 
                                       select employeeTypeId from v_fullmember where memberId =:memberId
                                    )";

        $param = array("memberId" => $memberId, "fieldmap" => "employeeTypeId");
        $details = $this->datacontext->pdoQuery($sqlDetails, $param);
        $matchId = array();
        foreach ($details as $valueId) {
            $condition = new Conditions();
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
            //print_r($dataCheck);
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

        $sqlDetails = "SELECT wfdt.detailsId as detailsId,wfdt.quantity,wfdt.returnTypeId, "
                . "wfdt.welfareId,  "
                . "rt.value1 As returntType,rt.id,"
                . "wf.name,wf.statusActive,wf.description "
                . " FROM  welfaredetails wfdt "
                . "Left JOIN  welfare wf "
                . "on wfdt.welfareId = wf.welfareId "
                . "Left JOIN taxonomy rt  "
                . "on wfdt.returnTypeId = rt.id "
                . "where detailsId in ( " . $id . " )";


        $objDetailsId = $this->datacontext->pdoQuery($sqlDetails);

        $i = 1;
        foreach ($objDetailsId as $key => $value) {

            $objDetailsId[$key]["rowNo"] = $i++;
        }

        $view->memberId = $memberId;

        $view->datasConditions = $objDetailsId;
        return $view;
    }

}
