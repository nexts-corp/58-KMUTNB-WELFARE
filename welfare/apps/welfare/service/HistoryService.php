<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IHistoryService;
use apps\welfare\entity\History;

class HistoryService extends CServiceBase implements IHistoryService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

   

    public function save($data) {
        
    if($this->datacontext->saveObject($data)){
    return true;
    }else{
    return false;
    
    }
    
    
    }

   

    public function update($data) {
        
        
        return $this->datacontext->updateObject($data);
        
        
    }
    
    public function delete($id) {
        $daoHistory = new History();
        $daoHistory->setHistoryId($id);
        
        if ($this->datacontext->removeObject($daoHistory)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

}