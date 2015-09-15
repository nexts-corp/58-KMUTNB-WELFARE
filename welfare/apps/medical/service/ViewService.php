<?php

namespace apps\medical\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\medical\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

//    public function defultAdd() {
//
//        $view = new CJView("default/add", CJViewType::HTML_VIEW_ENGINE);
//        $daoMedicalFee = new SettingMedicalFee();
//        $getObj = $this->datacontext->getObject($daoMedicalFee);
//        if ($getObj == null) {
//            $view->datas = new SettingMedicalFee();
//            return $view;
//        } else {
//            $view->datas = $getObj;
//
//            return $view;
//        }
//    }
    // end serviec view defult  
    // start serviec view medicalFee  

    public function medicalFeeAdd() {
        $view = new CJView("medicalfee/add", CJViewType::HTML_VIEW_ENGINE);
        $usertype = $this->getCurrentUser()->usertype;
        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => 1,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];
//        print $dateBudget["startDate"]." ".$dateBudget["endDate"];
//        exit();
        $datestart = $dateBudget["startDate"];
        $endddate = $dateBudget["endDate"];

        $sql1 = "select wh.welfareId,wh.memberId,wc.amount,sum(wh.amount),wc.amount-sum(wh.amount) as balance "
                . "from welfarehistory wh "
                . "inner join welfare wel "
                . "on wel.welfareId = wh.welfareId "
                . "inner join welfareconditions wc "
                . "on wc.conditionsId = wh.conditionsId "
                . "inner join member mem "
                . "on mem.memberId = wh.memberId"
                . "where wh.dateCreated between :datestart and :endddate "
                . "and wel.code = 'medical001' "
                . "and wh.conditionsId = 14 "
                . "and wh.welfareId = 1 "
                . "and wh.memberId = 4 ";

        $param = array(
            "datestart" => $datestart,
            "endddate" => $endddate,
            "retireyear" => $retireYear
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];
        return $view;
    }

//    public function medicalFeeEdit($id) {
//        $view = new CJView("medicalfee/edit", CJViewType::HTML_VIEW_ENGINE);
//        $daoHospitel = new Hospital();
//        $getObj = $this->datacontext->getObject($daoHospitel);
//        $path = '\\apps\\common\\entity\\';
//        $sql = "SELECT me.medicalFeeId,ti.titleNameTh,re.registerNameTh,re.registerLastNameTh,me.amount,ho.name "
//                . "FROM " . $path . "Medicalfee me "
//                . "INNER join " . $path . "Register re with me.registerId = re.registerId "
//                . "INNER join " . $path . "Titlename ti with re.titleNameId = ti.titleNameId "
//                . "INNER join " . $path . "Hospital ho with me.hospital = ho.hospitalId "
//                . "WHERE me.medicalFeeId = $id"
//                . "ORDER BY re.registerId DESC";
//
//        $getObjFac = $this->datacontext->getObject($sql);
//        $view->datasMedical = $getObj;
//        $view->datas = $getObjFac;
//        return $view;
//    }

    public function medicalFeeLists() {
        $view = new CJView("medicalfee/lists", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

}
