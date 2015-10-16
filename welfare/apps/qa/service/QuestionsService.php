<?php
namespace apps\qa\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\qa\entity\Questions;
use apps\qa\interfaces\IQuestionsService;
class QuestionsService extends CServiceBase implements IQuestionsService{
    
    
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

    public function update($questions) {
       
        
        $checkUpdate=$this->datacontext->updateObject($questions);
         if ($checkUpdate){
            return true;
        } else {
            return false;
        }
        
        
        
    }
    public function delete($questionsId) {
        if ($questionsId != "") {
            $questions = new \apps\qa\entity\Questions();
            $questions->setQuestionsId($questionsId);
            $this->datacontext->removeObject($questions);
            $this->getResponse()->add("message", "ลบข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return FALSE;
        }
    }

//put your code here
}
