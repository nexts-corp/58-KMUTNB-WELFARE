<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IHistoryService;
use apps\welfare\entity\History;
use apps\taxonomy\service\TaxonomyService;
use apps\common\entity\Nottifications;

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
        $this->datacontext->updateObject($data);

        $daoNft = new Nottifications();
        $daoNft->memberId = $data->memberId;
        $daoNft->nftAppId = $data->nftAppId;
        $daoNft->nftAppName = $data->nftAppName;
        $daoNft->nftStatus = "false";
        $daoNft->nftName = $data->nftName;
        $daoNft->nftLink = "api/welfare/view/user/lists";
        $this->datacontext->saveObject($daoNft);

        return true;
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

        $param = array("detailsId" => $data->detailsId, "welfareId" => $data->welfareId, "memberId" => $data->memberId);
        $objHistory = $this->datacontext->pdoQuery($sqlHistory, $param);

//        foreach($objHistory as $key => $value){
//           // $objHistory["dateUpdated"] =$value["dateUpdated"];
//            //$checkYear = explode("-",  $objHistory["dateUpdated"]);
//            print_r($value["dateUpdated"]);
//        }




        return $objHistory;
    }

    public function checkApprove() {
        $data = "";
        $objApprove = $this->checkStatus($data);
        return $objApprove;
    }

    public function checkStatus($data) {


        $where = "";
        if ($data != "") {

            switch ($data->statusApprove) {
                case 'YNP':
                    $where .="ap.statusApprove='P' or ap.statusApprove='N' or ap.statusApprove='Y'";
                    break;
                case 'Y':
                    $where .="ap.statusApprove='" . $data->statusApprove . "'";
                    break;
                case 'N':
                    $where .="ap.statusApprove='" . $data->statusApprove . "'";
                    break;
                case 'P':
                    $where .="ap.statusApprove='" . $data->statusApprove . "'";
                    break;    
            }

            if ($data->faculty) {
                $where .="And mb.facultyId='" . $data->faculty . "'";
            }else{
                $where .="";
            }
            if ($data->department) {
                $where .="And mb.departmentId='" . $data->department . "'";
            }else{
                $where .="";
            }
            if ($data->employeeType) {
                $where .="And mb.employeeTypeId='" . $data->employeeType . "'";
            }else{
                $where .="";
            }
            if ($data->gender) {
                $where .="And mb.genderId='" . $data->gender . "'";
            }else{
                $where .="";
            }
            if ($data->searchName) {
                $where .="And mb.fname LIKE '%" . $data->searchName . "%' or mb.lname LIKE '%" . $data->searchName . "%'";
            }else{
                $where .="";
            }
            
          
        } else {
            $where .="ap.statusApprove='P' or ap.statusApprove='N' or ap.statusApprove='Y'";
        }


        $sqlApprove = "SELECT ap.historyId,ap.statusApprove,ap.welfareId,ap.memberId,ap.detailsId,ap.dateUpdated , "
                . " IFNULL(mb.academic1,mb.titleName1) title  , mb.memberId , "
                . " mb.fname , mb.lname , mb.gender1, mb.department1,"
                . "mb.faculty1,mb.employeeType1 ,mb.facultyId ,mb.employeeTypeId ,mb.genderId ,mb.departmentId ,"
                . "wf.name,wf.description,wf.filename , "
                . "wfc.description as wfcdetails,wfc.quantity "
                . " FROM welfarehistory ap Left Join v_fullmember mb "
                . " on ap.memberId = mb.memberId "
                . "Left Join welfare wf "
                . "on ap.welfareId = wf.welfareId "
                . "Left Join welfaredetails wfc "
                . "on ap.detailsId=wfc.detailsId "
                . " where " . $where . " ";

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
