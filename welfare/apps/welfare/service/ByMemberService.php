<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IByMemberService;
use apps\welfare\entity\Conditions;
use apps\welfare\entity\Right;

class ByMemberService extends CServiceBase implements IByMemberService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function delete($id) {

        $daoConditions = new Conditions();
        $daoConditions->setConditionsId($id);

        if ($this->datacontext->removeObject($daoConditions)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function save($data) {
        
       
        foreach ($data as $key => $value) {
            if ($data[$key]->workStartDate != "") {
                
                $workStartDate1 = explode("-", $data[$key]->workStartDate);
                $workStartDate1[2] = intVal($workStartDate1[2]) - 543;
                $workStartDate = $workStartDate1[2] . "-" . $workStartDate1[1] . "-" . $workStartDate1[0];
                
                $data[$key]->workStartDate = new \DateTime($workStartDate);
            }
            if ($data[$key]->workEndDate != "") {
                
                $workEndDate1 = explode("-", $data[$key]->workEndDate);
                $workEndDate1[2] = intVal($workEndDate1[2]) - 543;
                $workStartDate = $workEndDate1[2] . "-" . $workEndDate1[1] . "-" . $workEndDate1[0];
        
                $data[$key]->workEndDate = new \DateTime($workStartDate);
            }
        }
        return $this->datacontext->saveObject($data);

    }

    public function update($data) {

        foreach ($data as $key => $value) {
            if ($data[$key]->workStartDate != "") {
                $data[$key]->workStartDate = new \DateTime($data[$key]->workStartDate);
            }
            if ($data[$key]->workEndDate != "") {
                $data[$key]->workEndDate = new \DateTime($data[$key]->workEndDate);
            }
        }

        return $this->datacontext->updateObject($data);
    }

    

   

}
