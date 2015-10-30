<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IHistoryService;
use apps\welfare\entity\History;
use apps\taxonomy\service\TaxonomyService;

class HistoryService extends CServiceBase implements IHistoryService {

    public $datacontext;
    public $taxonomy;
    public $common;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new TaxonomyService();
    }

    public function save($data) {
        
       
        
        if ($this->datacontext->saveObject($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data) {


        return $this->datacontext->updateObject($data);
    }

    public function delete($id) {
        $daoHistory = new History();
        $daoHistory->setHistoryId($id);

        if ($this->datacontext->removeObject($daoHistory)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function getHistory($data) {
        
    

        
       $sqlHistory = "SELECT * From welfarehistory htr "
                . "where htr.detailsId=:detailsId and welfareId=:welfareId and memberId=:memberId  Order By htr.historyId desc ";
       
        $param=array("detailsId"=>$data->detailsId,"welfareId"=>$data->welfareId,"memberId"=>$data->memberId);
        $objHistory = $this->datacontext->pdoQuery($sqlHistory,$param);
       
//        foreach($objHistory as $key => $value){
//           // $objHistory["dateUpdated"] =$value["dateUpdated"];
//            //$checkYear = explode("-",  $objHistory["dateUpdated"]);
//            print_r($value["dateUpdated"]);
//        }
            
        
        
        
        return $objHistory;
    }

    public function checkApprove() {
        $data="";
       $objApprove =  $this->checkStatus($data);
        return $objApprove;
      
    }

    public function checkStatus($data) {
        
      
        $where ="";
        if($data !=""){
          $where .="ap.statusApprove='".$data->statusApprove."'"; 
        }else{
        $where .="ap.statusApprove='P' or ap.statusApprove='N'";
        }
        
        $sqlApprove = "SELECT ap.historyId,ap.statusApprove,ap.welfareId,ap.memberId,ap.detailsId,"
                . " IFNULL(mb.academic1,mb.titleName1) title  , mb.memberId , "
                . " mb.fname , mb.lname , mb.gender1, mb.department1,"
                . "mb.faculty1,mb.employeeType1 ,"
                . "wf.name,wf.description,wf.filename , "
                . "wfc.description as wfcdetails,wfc.quantity "
                . " FROM welfarehistory ap Left Join v_fullmember mb "
                . " on ap.memberId = mb.memberId "
                . "Left Join welfare wf "
                . "on ap.welfareId = wf.welfareId "
                . "Left Join welfaredetails wfc "
                . "on ap.detailsId=wfc.detailsId "
                . " where ".$where." ";
                
       
        $objApprove = $this->datacontext->pdoQuery($sqlApprove);
        
        $i = 1;
        if ($objApprove != "") {


            foreach ($objApprove as $key => $value) {

                $objApprove[$key]["rowNo"] = $i++;
            }
        }
        
        
       return $objApprove; 
    }

}
