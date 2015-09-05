<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IConditionsService;
use apps\welfare\entity\Conditions;

class ConditionsService extends CServiceBase implements IConditionsService {

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
            if ($data[$key]->dateStartWork != "") {
                $data[$key]->dateStartWork = new \DateTime($data[$key]->dateStartWork);
            }
            if ($data[$key]->dateEndWork != "") {
                $data[$key]->dateEndWork = new \DateTime($data[$key]->dateEndWork);
            }
        }
        
        return $this->datacontext->saveObject($data);

    }

    public function update($data) {
        
        foreach ($data as $key => $value) {
            if ($data[$key]->dateStartWork != "") {
                $data[$key]->dateStartWork = new \DateTime($data[$key]->dateStartWork);
            }
            if ($data[$key]->dateEndWork != "") {
                $data[$key]->dateEndWork = new \DateTime($data[$key]->dateEndWork);
            }
        }
       
       return $this->datacontext->updateObject($data);
       
        
    }
    
    

}
