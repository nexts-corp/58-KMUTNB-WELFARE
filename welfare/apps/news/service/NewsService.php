<?php

namespace apps\news\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\news\entity\News;
use apps\news\interfaces\INewsService;
use apps\common\entity\Nottifications;
use apps\member\entity\Work;

class NewsService extends CServiceBase implements INewsService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($news) {

        $employeeTypeId = "";

        foreach ($news->employeeTypeId as $key => $value) {

            $pluss = "";
            if ($key == 0) {
                $pluss .="";
            } else {
                $pluss .=",";
            }

            $employeeTypeId .= $pluss . "" . $value;
        }

        $news->employeeTypeId = $employeeTypeId;

        if ($this->datacontext->saveObject($news)) {

            $pathMember = "apps\\member\\entity\\";
            $sqlMember = "SELECT mb.memberId, mb.employeeTypeId "
                    . " From " . $pathMember . "Work mb where mb.employeeTypeId IN (" . $employeeTypeId . ") ";

            $objMember = $this->datacontext->getObject($sqlMember);

            for ($i = 0; $i < count($objMember); $i++) {
                $daoNft = new Nottifications();
                $daoNft->memberId = $objMember[$i]["memberId"];
                $daoNft->nftAppId = $news->newsId;
                $daoNft->nftAppName = "newsId";
                $daoNft->nftStatus = "false";
                $daoNft->nftName = $news->newsName;
                $daoNft->nftLink = "api/news/user/view/news/read";
                $this->datacontext->saveObject($daoNft);
            }

            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function update($news) {

        $employeeTypeId = "";

        foreach ($news->employeeTypeId as $key => $value) {

            $pluss = "";
            if ($key == 0) {
                $pluss .="";
            } else {
                $pluss .=",";
            }

            $employeeTypeId .= $pluss . "" . $value;
        }

        $news->employeeTypeId = $employeeTypeId;
        $checkUpdate = $this->datacontext->updateObject($news);
        if ($checkUpdate) {
            return true;
        } else {
            return false;
        }
    }

    public function ntfUpdate($nft) {
        
       
        $checkUpdate = $this->datacontext->updateObject($nft);
        if ($checkUpdate) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($newsId) {
        if ($newsId != "") {
            $news = new \apps\news\entity\News();
            $news->setNewsId($newsId);
            $this->datacontext->removeObject($news);
            $this->getResponse()->add("message", "ลบข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return FALSE;
        }
    }

//put your code here
}
