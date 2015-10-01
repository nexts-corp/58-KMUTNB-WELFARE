<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\taxonomy\service\TaxonomyService;
use apps\common\service\CommonService;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IViewAdminService;
use apps\welfare\entity\Welfare;
use apps\welfare\entity\Details;
use apps\welfare\entity\Conditions;
use apps\welfare\entity\History;

class ViewAdminService extends CServiceBase implements IViewAdminService {

    public $datacontext;
    public $taxonomy;
    public $common;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new TaxonomyService();
        $this->common = new CommonService();
    }

    public function welfareLists() {
        $view = new CJView("admin/welfare/lists", CJViewType::HTML_VIEW_ENGINE);
        $daoWelfare = new Welfare();
        $obj = $this->datacontext->getObject($daoWelfare);
        $obj = $this->common->afterGet($obj);
//        if (count($obj) > 0) {
//            foreach ($obj as $key => $value) {
//                if ($value->dateStart != "") {
//                    $dsY = $value->dateStart->format('Y') + 543;
//                    $obj[$key]->dateStart = $value->dateStart->format('d-m-' . $dsY);
//                }
//                if ($value->dateEnd != "") {
//                    $deY = $value->dateEnd->format('Y') + 543;
//                    $obj[$key]->dateEnd = $value->dateEnd->format('d-m-' . $deY);
//                }
//            }
//        }
          
            foreach ($obj as $key => $value ){
                
                if($obj[$key]->resetTime =="12"){
                $obj[$key]->resetTime="ทุก 1 ปี";
                }elseif($obj[$key]->resetTime=="0"){
                    $obj[$key]->resetTime="ครั้งเดียว";
                }elseif($obj[$key]->resetTime=="6"){
                    $obj[$key]->resetTime="ทุก 6 เดือน";
                }
                
            }
        
        
        $view->datas = $obj;
        return $view;
    }

    public function welfareAdd() {
        $view = new CJView("admin/welfare/add", CJViewType::HTML_VIEW_ENGINE);
        $view->unit = $this->taxonomy->getPCode("unit");
        return $view;
    }

    public function welfareEdit() {
        $view = new CJView("admin/welfare/edit", CJViewType::HTML_VIEW_ENGINE);
        $welfareId = $this->getRequest()->welfareId;
        $wel = new WelfareService();
        $view->welfare = $wel->get($welfareId);
        $view->unit = $this->taxonomy->getPCode("unit");
        return $view;
    }

    public function approveLists() {

        $view = new CJView("admin/approve/lists", CJViewType::HTML_VIEW_ENGINE);

        $sqlApprove = "SELECT ap.historyId,ap.statusApprove,ap.welfareId,ap.memberId,ap.detailsId,"
                . " IFNULL(mb.academic1,mb.titleName1) title  , mb.memberId , "
                . " mb.fname , mb.lname , "
                . "wf.name,wf.description,"
                . "wfc.description as wfcdetails,wfc.quantity "
                . " FROM welfarehistory ap Left Join v_fullmember mb "
                . " on ap.memberId = mb.memberId "
                . "Left Join welfare wf "
                . "on ap.welfareId = wf.welfareId "
                . "Left Join welfaredetails wfc "
                . "on ap.detailsId=wfc.detailsId "
                . " where ap.statusApprove='P' ";


        $objApprove = $this->datacontext->pdoQuery($sqlApprove);
        
        
        
        $i = 1;
        if ($objApprove != "") {
          
            
            foreach ($objApprove as $key => $value) {

                $objApprove[$key]["rowNo"] = $i++;
            }
        }
        $view->dataApprove = $objApprove;


        return $view;
    }

}
