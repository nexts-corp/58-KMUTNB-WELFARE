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

    public function save($data) {

        $details = $data->details;
        if ($data->dateStart != "") {
            $dateStart = explode("-", $data->dateStart);
            $dateStart[2] = intVal($dateStart[2]) - 543;
            $dateStart1 = $dateStart[2] . "-" . $dateStart[1] . "-" . $dateStart[0];

            $data->dateStart = new \DateTime($dateStart1);
        }
        if ($data->dateEnd != "") {
            $dateEnd = explode("-", $data->dateEnd);
            $dateEnd[2] = intVal($dateEnd[2]) - 543;
            $dateEnd1 = $dateEnd[2] . "-" . $dateEnd[1] . "-" . $dateEnd[0];

            $data->dateEnd = new \DateTime($dateEnd1);
        }


        if ($this->datacontext->saveObject($data)) {
            $welfareId = $data->welfareId;
            foreach ($details as $key => $value) {
                $wd = new \apps\welfare\entity\Details();
                $wd->welfareId = $welfareId;
                $wd->description = $value->description;
                $wd->quantity = $value->quantity;
                $wd->returnTypeId = $value->returnTypeId;
                if ($value->filename != "") {
                    $wd->filename = $value->filename;
                }
                $condition = $value->conditions;
                if ($this->datacontext->saveObject($wd)) {
                    $detailsId = $wd->detailsId;
                    foreach ($condition as $key2 => $value2) {
                        $cd = new \apps\welfare\entity\Conditions();
                        $cd->welfareId = $welfareId;
                        $cd->detailsId = $detailsId;
                        $cd->fieldMap = $value2->fieldMap;
                        $cd->operations = $value2->operations;
                        $cd->valuex = $value2->valuex;
                        $this->datacontext->saveObject($cd);
                    }
                }
            }

            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }

        return $data;
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
                    foreach ($conditions as $key2 => $value2) {
                        if (empty($value2->conditionsId)) {
                            $value2->welfareId = $welfareId;
                            $value2->detailsId = $detailsId;
                            $this->datacontext->saveObject($value2);
                        } else {
                            $this->datacontext->updateObject($value2);
                        }
                    }
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

}
