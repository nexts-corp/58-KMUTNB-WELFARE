<?php
namespace apps\qa\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\qa\entity\Questions;
use apps\qa\interfaces\IAnswerService;
class AnswerService extends CServiceBase implements IAnswerService{
    
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($datas) {
        
        if ($this->datacontext->saveObject($datas)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
        
    }

    public function update($datas) {
        
        
        $checkUpdate=$this->datacontext->updateObject($datas);
         if ($checkUpdate){
            return true;
        } else {
            return false;
        }
        
        
        
    }

//put your code here
}
