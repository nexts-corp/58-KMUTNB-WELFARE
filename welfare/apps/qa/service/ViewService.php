<?php

namespace apps\qa\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\taxonomy\entity\Taxonomy;
use apps\qa\entity\Questions;
use apps\qa\interfaces\IViewService;
use apps\qa\entity\MultiFile;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;
    public $taxonomy;
    public $common;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
        $this->common = new \apps\common\service\CommonService();
    }

    public function questionsAdd() {
        
           $view = new CJView("admin/questions/add", CJViewType::HTML_VIEW_ENGINE);
        
           return $view;
           
    }

    public function questionsEdit() {
        
         $questionsId=$this->getRequest()->questionsId;
        
       $view = new CJView("admin/questions/edit", CJViewType::HTML_VIEW_ENGINE);
        $path = "apps\\qa\\entity\\";

        $sqlQuestions = "SELECT qa.questionsName,qa.questionsId ,qa.questionsDetails "
                . " From " . $path . "Questions qa Where qa.questionsId=:questionsId";
        $param=array("questionsId"=>$questionsId);
        $objQuestions = $this->datacontext->getObject($sqlQuestions,$param);
        $view->datasQuestions=$objQuestions;
        $view->questionsId=$questionsId;
     
        return $view;
    }

    public function questionsList() {
        
        $view = new CJView("admin/questions/lists", CJViewType::HTML_VIEW_ENGINE);
        $objQuestions = $this->datacontext->getObject(new Questions());
        $objQuestions = $this->common->afterGet($objQuestions,array("dateUpdated"));
       
       
        
        $i = 1;
        if ($objQuestions != "") {
            foreach ($objQuestions as $key => $value) {

                $objQuestions[$key]->rowNo = $i++;
            }
        }
        $view->datasQuestions = $objQuestions;
        
        return $view;
    }

    public function contactUs() {
       $view = new CJView("user/contactUs/detail", CJViewType::HTML_VIEW_ENGINE);
       return $view;
    }

}
