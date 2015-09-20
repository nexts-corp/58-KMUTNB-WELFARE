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

    public function ssoAdminLists() {
        $view = new CJView("sso/admin/lists", CJViewType::HTML_VIEW_ENGINE);
        $sso = new SSOService();
        $view->lists = $sso->lists();
        return $view;
    }

    public function ssoUserLists() {
        if ($this->getRequest()->memberId != "") {
            $memberId = $this->getRequest()->memberId;
            $view = new CJView("sso/admin/user", CJViewType::HTML_VIEW_ENGINE);
        } else {
            $memberId = $this->getCurrentUser()->code;
            $view = new CJView("sso/user/lists", CJViewType::HTML_VIEW_ENGINE);
        }
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
        if (count($dataHospital) > 0) {
            $view->requestHospital = $dataHospital[0]->hospital;
        } else {
            $view->requestHospital = " - ";
        }
        $mb = new \apps\member\service\MemberService();
        $view->member = $mb->find("memberId", $memberId)[0];
        $view->datas = $datas;
        return $view;
    }

    public function lifeAdminLists() {

        $view = new CJView("life/admin/lists", CJViewType::HTML_VIEW_ENGINE);
        $life = new LifeService();
        $view->lists = $life->lists();
        return $view;
    }

    public function lifeUserLists() {

        $view = new CJView("life/user/lists", CJViewType::HTML_VIEW_ENGINE);
        $memberId = $this->getCurrentUser()->code;
        $sql = "select fm.*,ifnull(fm.academic1,fm.titleName1) as titleName, "
                . "inf.lifeId, inf.payment,inf.received,inf.protectYear  "
                . "from v_fullmember fm "
                . "join insurancelife inf "
                . "on inf.memberId = fm.memberId "
                . "where inf.memberId = :memberId "
                . "order by inf.protectYear desc";
        $param = array(
            "memberId" => $memberId
        );
        $datas = $this->datacontext->pdoQuery($sql, $param);
        $i = 1;
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $datas[$key]['rowNo'] = $i++;
                if ($value['payment'] == "yes") {
                    $datas[$key]['payment'] = "ชำระเงินแล้ว";
                } else {
                    $datas[$key]['payment'] = "ยังไม่ชำระเงิน";
                }
                if ($key == "protectYear") {
                    $datas[$key]['protectYear'] = intval($datas[$key]['protectYear'])+543;
                }
            }
        }
        $view->lists = $datas;
        return $view;
    }

}
