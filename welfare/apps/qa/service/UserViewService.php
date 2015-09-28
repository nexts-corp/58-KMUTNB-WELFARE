<?php

namespace apps\qa\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\taxonomy\entity\Taxonomy;
use apps\qa\entity\News;
use apps\qa\interfaces\IUserViewService;
use apps\qa\entity\Answer;
use apps\qa\entity\Questions;

class UserViewService extends CServiceBase implements IUserViewService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
        $this->common = new \apps\common\service\CommonService();
    }

    public function questionsAdd() {
        $view = new CJView("user/questions/add", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function qaList() {
        $view = new CJView("user/questions/lists", CJViewType::HTML_VIEW_ENGINE);
        $objQuestions = $this->datacontext->getObject(new Questions());
        $objQuestions = $this->common->afterGet($objQuestions, array("dateUpdated"));
        

        $i = 1;
        if ($objQuestions != "") {
            foreach ($objQuestions as $key => $value) {

                $objQuestions[$key]->rowNo = $i++;
            }
        }
        $view->datasQuestions = $objQuestions;




        return $view;
    }

    public function qaRead() {

        $questionsId = $this->getRequest()->questionsId;

        $view = new CJView("user/questions/readQuestions", CJViewType::HTML_VIEW_ENGINE);
        $path = "apps\\qa\\entity\\";

        $sqlQuestions = "SELECT qa.questionsName,qa.questionsId ,qa.questionsDetails "
                . " From " . $path . "Questions qa Where qa.questionsId=:questionsId";
        $param = array("questionsId" => $questionsId);
        $objQuestions = $this->datacontext->getObject($sqlQuestions, $param);

        $view->datasQuestions = $objQuestions;
        $view->questionsId = $questionsId;

        $sqlAnswer = "SELECT aw.answerDetails,aw.questionsId,aw.createBy,aw.dateCreated  "
                . " From " . $path . "Answer aw Where aw.questionsId=:questionsId";
        $objAnswer = $this->datacontext->getObject($sqlAnswer, $param);

        foreach ($objAnswer as $key => $value) {

            $objAnswer[$key]["dateCreated"] = $value["dateCreated"]->format("d-m-Y H:i:s");
        }


        if ($objAnswer != "") {

            $i = 1;
            foreach ($objAnswer as $key => $value) {
                $objAnswer[$key]["rowsNo"] = $i++;
            }


            $view->datasAnswer = $objAnswer;
        }

        return $view;
    }

}
