<?php

namespace apps\menu\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\menu\interfaces\IViewService;
use apps\common\entity\Nottifications;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function header() {
        $view = new CJView("header", CJViewType::HTML_VIEW_ENGINE);

        $code = $this->getCurrentUser()->code;
        $view->code = $code;
        $view->profile = $this->getCurrentUser()->name;
        $view->userType = $this->getCurrentUser()->usertype;
        $view->titleName = $this->getCurrentUser()->titleName;

        $pathNft = "apps\\common\\entity\\";

        $sqlNft = "SELECT nft.memberId, nft.nftName,nft.nftAppName,nft.nftStatus,nft.nftLink,nft.nftAppId,nft.dateCreated "
                . " From " . $pathNft . "Nottifications nft where nft.nftStatus='false' And nft.memberId =" . $code . "  ";

        $objNft = $this->datacontext->getObject($sqlNft);
        if ($objNft != "") {
            foreach ($objNft as $key => $value) {
                $objNft[$key]["dateCreated"] = $value["dateCreated"]->format("d-m-Y");
            }
        }
        $view->datasNft = $objNft;

        $i = 0;
        foreach ($objNft as $key => $value) {
            $objNft[$key] = $i++;
        }

        $view->total = $i--;

        return $view;
    }

    public function admin() {
        $view = new CJView("menu/admin", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function member() {

        $view = new CJView("menu/member", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getCurrentUser()->code;
        return $view;
    }

    public function department() {

        $view = new CJView("menu/department", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getCurrentUser()->code;
        return $view;
    }

    public function faculty() {

        $view = new CJView("menu/faculty", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getCurrentUser()->code;
        return $view;
    }

    public function medical() {
        $view = new CJView("menu/medical", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getCurrentUser()->code;
        return $view;
    }

    public function extraUser() {
         $view = new CJView("menu/extraUser", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getCurrentUser()->code;
        return $view;
    }

    public function governmentUser() {
        $view = new CJView("menu/governmentUser", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getCurrentUser()->code;
        return $view;
    }

    public function retireUser() {
        $view = new CJView("menu/governmentUser", CJViewType::HTML_VIEW_ENGINE);
        $view->code = $this->getCurrentUser()->code;
        return $view;
    }

}
