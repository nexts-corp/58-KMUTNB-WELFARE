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
