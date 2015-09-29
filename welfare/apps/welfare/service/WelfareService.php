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

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->common = new CommonService();
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

        if ($this->datacontext->removeObject($daoWelfare)) {
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

}
