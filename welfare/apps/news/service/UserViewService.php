<?php

namespace apps\news\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\taxonomy\entity\Taxonomy;
use apps\news\entity\News;
use apps\news\interfaces\IUserViewService;
use apps\news\entity\MultiFile;
use apps\member\entity\Work;
use apps\common\entity\Nottifications;

class UserViewService extends CServiceBase implements IUserViewService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new \apps\taxonomy\service\TaxonomyService();
    }

    public function newsList() {
        $view = new CJView("user/news/lists", CJViewType::HTML_VIEW_ENGINE);

        $path = "apps\\news\\entity\\";
        $pathMember = "apps\\member\\entity\\";
        
        $memberId=$this->getCurrentUser()->code;
        
        $sqlMember="SELECT mb.memberId, mb.employeeTypeId "
                . " From ".$pathMember."Work mb where mb.memberId =:memberId ";
        $paramMember=array("memberId"=>$memberId);
       
        $objMember=$this->datacontext->getObject($sqlMember,$paramMember)[0];
        $employeeType= $objMember["employeeTypeId"];
       
        
        $sqlNews = "SELECT nw.newsName,nw.newsId ,nw.employeeTypeId,nw.dateCreated,nw.newsDetails "
                . " From " . $path . "News nw Where nw.employeeTypeId LIKE '%".$employeeType."%' Order By nw.newsId DESC ";
        $objNews = $this->datacontext->getObject($sqlNews);
       
      
        foreach ($objNews as $key => $value) {
          $objNews[$key]["dateCreated"] = $value["dateCreated"]->format('d-m-Y');
          $objNews[$key]["newsDetails"] = strip_tags($value["newsDetails"]);
        }
        $i = 1;
        if ($objNews != "") {
            foreach ($objNews as $key => $value) {

                $objNews[$key]["rowNo"] = $i++;
            }

            $view->datasNews = $objNews;
        }
       
        return $view;
    }

   

    public function newsRead() {
       
        $newsId=$this->getRequest()->newsId;
        $memberId=$this->getCurrentUser()->code;
        
       
      
       
        
       $view = new CJView("user/news/readNews", CJViewType::HTML_VIEW_ENGINE);
        $path = "apps\\news\\entity\\";

        $sqlNews = "SELECT nw.newsName,nw.newsId ,nw.employeeTypeId,nw.newsDetails "
                . " From " . $path . "News nw Where nw.newsId=:newsId";
        $param=array("newsId"=>$newsId);
        $objNews = $this->datacontext->getObject($sqlNews,$param);
        $view->datasNews=$objNews;
        
        $sqlMultifile = "SELECT mf.multiFileName,mf.newsId "
                . " From " . $path . "MultiFile mf Where mf.newsId=:newsId";
        $objMultifile = $this->datacontext->getObject($sqlMultifile,$param);
        
        $i=1;
        foreach ($objMultifile as $key => $value) {
            $objMultifile[$key]["rowsNo"]=$i++;
            
        }
       
        
        $view->datasMultiFile=$objMultifile;
        $view->newsId=$newsId;
        $view->memberId=$memberId;
        
        $sqlNft = "SELECT nft.nftId,nft.memberId, nft.nftAppId ,nft.nftStatus "
                    . " From apps\\common\\entity\\Nottifications nft "
               . " where nft.memberId=:memberId And nft.nftAppId=:nftAppId And nft.nftStatus='false' ";
      
        $paramArray=array("memberId"=>$memberId,"nftAppId"=>$newsId);
        
        $objNft = $this->datacontext->getObject($sqlNft,$paramArray);
        
        if(!$objNft){
        $view->nftId=$objNft[0]['nftId'];
        }
        
        
        return $view;

    }

}
