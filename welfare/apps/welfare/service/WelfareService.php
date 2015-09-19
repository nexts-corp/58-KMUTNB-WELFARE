<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IWelfareService;
use apps\welfare\entity\Welfare;
use apps\taxonomy\entity\Taxonomy;

class WelfareService extends CServiceBase implements IWelfareService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
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
                $condition = $value->conditions;
                if ($this->datacontext->saveObject($wd)) {
                    $detailsId = $wd->detailsId;
                    foreach($condition as $key2 => $value2){
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

    public function update($data) {

        $data->dateStart = new \DateTime($data->dateStart);
        $data->dateEnd = new \DateTime($data->dateEnd);



        if ($this->datacontext->updateObject($data)) {
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

//put your code here
}
