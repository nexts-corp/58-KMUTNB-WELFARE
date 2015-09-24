<?php

namespace apps\news\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\taxonomy\entity\Taxonomy;
use apps\news\entity\News;
use apps\news\interfaces\IViewService;
use apps\news\entity\MultiFile;
class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function newsList() {
        $view = new CJView("news/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoNews = new News();
        $objNews = $this->datacontext->getObject($daoNews);

        $i = 1;

        foreach ($objNews as $key => $value) {
            $objNews[$key]->rowNo =$i++;
       
        }
        $view->datasNews = $objNews;

        return $view;
    }

    public function newsAdd() {
        $view = new CJView("news/add", CJViewType::HTML_VIEW_ENGINE);

        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);

        return $view;
    }

    public function newsEdit() {
        
        $newsId = $this->getRequest()->newsId;
        
        $view = new CJView("news/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoNews = new News();
        $daoNews->setNewsId($newsId);
        $objNews = $this->datacontext->getObject($daoNews);
        
        
        
        $view->newsId=$newsId;
        $view->datasNews=$objNews;
        return $view;
    }

    public function fileList() {
        
        $newsId = $this->getRequest()->newsId;

        $view = new CJView("file/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoFile = new MultiFile();
        $daoFile->setNewsId($newsId);
        $objFile = $this->datacontext->getObject($daoFile);
        
        $i = 1;
        
        foreach ($objFile as $key => $value) {
            $objFile[$key]->rowNo =$i++;
       
        }
        $view->datasNews = $objFile;
        $view->newsId=$newsId;
        return $view;
        
    }

}
