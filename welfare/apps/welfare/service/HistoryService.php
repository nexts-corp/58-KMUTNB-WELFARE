<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IHistoryService;
use apps\welfare\entity\History;
use apps\common\service\CommonService;
use apps\taxonomy\service\TaxonomyService;
use apps\common\entity\Nottifications;

class HistoryService extends CServiceBase implements IHistoryService {

    public $datacontext;
    public $taxonomy;
    public $common;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new TaxonomyService();
        $this->common = new CommonService();
    }

    public function save($data) {

        if ($data->dateUse != "") {
            $data->dateUse = $this->common->str2date($data->dateUse, "d-m-Y", "-");
        }

        if ($this->datacontext->saveObject($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data) {
        
        $this->datacontext->updateObject($data);

//        $daoNft = new Nottifications();
//        $daoNft->memberId = $data->memberId;
//        $daoNft->nftAppId = $data->nftAppId;
//        $daoNft->nftAppName = $data->nftAppName;
//        $daoNft->nftStatus = "false";
//        $daoNft->nftName = $data->nftName;
//        $daoNft->nftLink = "api/welfare/view/user/lists";
//        $this->datacontext->saveObject($daoNft);

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
        /*
         * 
        $where = "";
        if ($data != "") {

            $where .="ap.statusApprove='Y' ";
                   

            if ($data->faculty) {
                $where .="And mb.facultyId='" . $data->faculty . "'";
            } else {
                $where .="";
            }
            if ($data->department) {
                $where .="And mb.departmentId='" . $data->department . "'";
            } else {
                $where .="";
            }
            if ($data->employeeType) {
                $where .="And mb.employeeTypeId='" . $data->employeeType . "'";
            } else {
                $where .="";
            }
          
            if ($data->searchName) {
                $where .="And mb.fname LIKE '%" . $data->searchName . "%' or mb.lname LIKE '%" . $data->searchName . "%'";
            } else {
                $where .="";
            }
        } else {
            $where .=" ap.statusApprove='Y'";
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
        */
        
        $sqlApprove = "select 
            welhist.historyId as historyId, 
            mb.memberId as memberId, mb.idCard as idCard,
            title.value1 as title, mb.fname as fname, mb.lname as lname,
            gender.id as genderId, gender.value1 as gender1,
            faculty.id as facultyId, faculty.value1 as faculty1,
            dept.id as departmentId, dept.value1 as department1,
            employee.id as employeeTypeId, employee.value1 as employeeType1,
            welhist.statusApprove as statusApprove
            from member mb 
            inner join welfarehistory welhist on mb.memberId = welhist.memberId
            inner join memberwork mbwork on mbwork.memberId = mb.memberId
            inner join taxonomy title on title.id = mb.titleNameId
            inner join taxonomy gender on gender.id = mb.genderId
            inner join taxonomy employee on employee.id = mbwork.employeeTypeId
            inner join taxonomy faculty on faculty.id = mbwork.facultyId
            inner join taxonomy dept on dept.id = mbwork.departmentId";
        
        
        

        $objApprove = $this->datacontext->pdoQuery($sqlApprove);
        
        $i = 1;
        if ($objApprove != "") {


            foreach ($objApprove as $key => $value) {

                $objApprove[$key]["rowNo"] = $i++;
            }
        }

        return $objApprove;
    }

    public function getHistoryAll($data) {
        
         $sqlDetails = "SELECT hr.detailsId,hr.remark,hr.amount,hr.dateUse ,"
                 . "wfdt.detailsId ,wfdt.quantity,wfdt.returnTypeId,wfdt.description as dcpDetails , "
                . "wf.welfareId,wf.name,  "
                . "rt.value1 As returntType,rt.id,"
                . "wf.name,wf.statusActive,wf.description  "
                . " FROM  welfarehistory hr "
                 . "left join welfare wf "
                 . "on hr.welfareId=wf.welfareId "
                 . "left join welfaredetails wfdt "
                 . "on hr.detailsId = wfdt.detailsId "
                 . "left join taxonomy rt "
                 . "on wfdt.returnTypeId = rt.id "
                 . "where hr.memberId=:memberId  ";
                  
        $param = array( "memberId" => $data->memberId );
  
        $objdetails = $this->datacontext->pdoQuery($sqlDetails, $param);
        
        if($objdetails != 0){
             return $objdetails;
        }else{
            return false;
        }
       
        
    }

}
