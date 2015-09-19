<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\insurance\interfaces\IViewService;
use apps\taxonomy\entity\Taxonomy;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function ssoAdminAdd() {
        $view = new CJView("sso/admin/add", CJViewType::HTML_VIEW_ENGINE);
        $taxTitleName = new Taxonomy();
        $taxTitleName->pCode = "titleName";

        return $view;
    }

    public function ssoAdminEdit() {
        $view = new CJView("sso/admin/edit", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function ssoAdminLists() {
        $view = new CJView("sso/admin/lists", CJViewType::HTML_VIEW_ENGINE);
        $sso = new SSOService();
        $view->lists = $sso->lists();
        return $view;
    }

    public function ssoUserLists() {
        $view = new CJView("sso/user/lists", CJViewType::HTML_VIEW_ENGINE);
        $memberId = $this->getCurrentUser()->code;
        $sso = "select sso from apps\\insurance\\entity\\SSO sso "
                . "where sso.memberId = :memberId "
                . "order by sso.id desc";
        $param = array(
            "memberId" => $memberId
        );
        $datas = $this->datacontext->getObject($sso, $param);
        $i = 1;
        foreach ($datas as $key => $value) {
            $datas[$key]->rowNo = $i++;
            foreach ($value as $key2 => $value2) {
                if (strpos($key2, "Date") || $key2 == "dateCreated") {
                    $date = explode("-", $value2->format("Y-m-d"));
                    $date = $date[2] . "-" . $date[1] . "-" . intval($date[0] + 543);
                    $datas[$key]->$key2 = $date;
                }
            }
        }
        $view->hospital = $datas[0]->hospital;

        $hospital = new \apps\insurance\entity\SSOHospital();
        $hospital->memberId = $memberId;
        $dataHospital = $this->datacontext->getObject($hospital);
        if(count($dataHospital)>0){
            $view->requestHospital = $dataHospital[0]->hospital;
        }else{
            $view->requestHospital = "-";
        }
        
        $view->datas = $datas;
        return $view;
    }

}
