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
    public $taxonomy;
    public $common;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
        $this->common = new \apps\common\service\CommonService();
    }

    public function newsList() {
        $view = new CJView("admin/news/lists", CJViewType::HTML_VIEW_ENGINE);

        $path = "apps\\news\\entity\\";


//        $sqlNews = "SELECT nw.newsName,nw.newsId ,nw.employeeTypeId,nw.date "
//                . " From " . $path . "News nw ";
        $objNews = $this->datacontext->getObject(new News());
        $objNews = $this->common->afterGet($objNews, array("dateUpdated", "createBy"));


        foreach ($objNews as $key => $value) {
            foreach ($value as $key1 => $value1) {
                if ($key1 == "employeeTypeId") {
                    $empId = explode(",", $value1);
                    //print_r($empId);
                    $empName = "";
                    foreach ($empId as $index => $id) {
                        if ($index == 0) {
                            $empName .= $this->taxonomy->getId($id)[0]->value1;
                        } else {
                            $empName .= "," . $this->taxonomy->getId($id)[0]->value1;
                        }
                    }
                    $objNews[$key]->employeeTypeId = $empName;
                }
            }
        }
        $i = 1;
        if ($objNews != "") {
            foreach ($objNews as $key => $value) {

                $objNews[$key]->rowNo = $i++;
            }
            $view->datasNews = $objNews;
        }
        $view->datasNews = $objNews;
        return $view;
    }

    public function newsAdd() {
        $view = new CJView("admin/news/add", CJViewType::HTML_VIEW_ENGINE);

        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);

        return $view;
    }

    public function newsEdit() {

        $newsId = $this->getRequest()->newsId;
        
        $view = new CJView("admin/news/edit", CJViewType::HTML_VIEW_ENGINE);
        $daoNews = new News();
        $daoNews->setNewsId($newsId);
        $objNews = $this->datacontext->getObject($daoNews)[0];
//        if ($objNews->employeeTypeId != "") {
//            $empId = explode(",", $objNews->employeeTypeId);
//            $objNews->employeeTypeId = $empId;
//            print_r($objNews->employeeTypeId);
//        }

        $employeeType = new Taxonomy();
        $employeeType->pCode = "employeeType";
        $view->employeeType = $this->datacontext->getObject($employeeType);


        $view->newsId = $newsId;
        $view->datasNews = $objNews;
        return $view;
    }

    public function fileList() {

        $newsId = $this->getRequest()->newsId;

        $view = new CJView("admin/file/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoFile = new MultiFile();
        $daoFile->setNewsId($newsId);
        $objFile = $this->datacontext->getObject($daoFile);



        $i = 1;

        foreach ($objFile as $key => $value) {
            $objFile[$key]->rowNo = $i++;
        }
        $view->datasNews = $objFile;
        $view->newsId = $newsId;
        return $view;
    }

}
