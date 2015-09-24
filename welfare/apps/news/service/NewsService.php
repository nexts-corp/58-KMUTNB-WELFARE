<?php
namespace apps\news\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\news\entity\News;
use apps\news\interfaces\INewsService;
class NewsService extends CServiceBase implements INewsService{
    
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($news) {
        
        
        
       
        if ($this->datacontext->saveObject($news)) {
            
            
//            $newsId = $data->newsId;
//            $mf = new \apps\news\entity\MultiFile();
//            $mf->newsId = $newsId;
//            $mf->multiFileName=$multifile;
//            $this->datacontext->saveObject($mf);
            
               
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
        
    }

//put your code here
}
