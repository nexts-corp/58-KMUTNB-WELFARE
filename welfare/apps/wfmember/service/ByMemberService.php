<?php

namespace apps\wfmember\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\wfmember\interfaces\IByMemberService;
use apps\wfmember\entity\Conditions;


class ByMemberService extends CServiceBase implements IByMemberService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function delete($id) {

        $daoConditions = new Conditions();
        $daoConditions->setConditionsId($id);

        if ($this->datacontext->removeObject($daoConditions)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function historyGet($data) {
      
        $detailsId = $data->detailsId;
        $memberId = $data->memberId;
        $welfareId = $data->welfareId;

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];


        $path = '\\apps\\taxonomy\\entity\\';
        $parthWelfare = '\\apps\\welfare\\entity\\';

        $sqlWelfare = "SELECT dt.welfareId,dt.description , dt.quantity,"
                . "wf.welfareId , wf.name , wf.description, "
                . "wf.description As wfDescription, wf.dateStart, "
                . "wf.resetTime , wf.dateEnd , wf.free , "
                . "rt.id As returnType , rt.value1 As returnTypeValue  "
                . "FROM " . $parthWelfare . "Details dt "
                . "Left JOIN " . $parthWelfare . "Welfare wf "
                . "with dt.welfareId = wf.welfareId "
                . "Left JOIN " . $path . "Taxonomy  rt  "
                . "with dt.returnTypeId = rt.id "
                . "where dt.detailsId = :detailsId";
        $param = array(
            "detailsId" => $detailsId
        );
        $objWelfare = $this->datacontext->getObject($sqlWelfare, $param)[0];
        if($dateBudget["startDate"]){
        $year543 = explode("-", $dateBudget["startDate"]);
        $objWelfare["dateStart"] = $year543[2] . "-" . $year543[1] . "-" . intval($year543[0] + 543);
        }
        if($dateBudget["endDate"]){
        $year543 = explode("-", $dateBudget["endDate"]);
        $objWelfare["dateEnd"] = $year543[2] . "-" . $year543[1] . "-" . intval($year543[0] + 543);
        }

        if ($objWelfare['free'] == "Y" || $objWelfare['free'] == null) {
            $objWelfare['free'] = "สวัสดิการให้เปล่า";
        } else {
            $objWelfare['free'] = "สวัสดิการให้ยืม";
        }

        if ($objWelfare['resetTime'] == "0") {
            $objWelfare['resetTime'] = "ให้ครั้งเดียว";
        } elseif ($objWelfare['resetTime'] == "6") {
            $objWelfare['resetTime'] = "ให้ทุก 6 เดือน";
        } elseif ($objWelfare['resetTime'] == "12") {
            $objWelfare['resetTime'] = "ให้ทุก 1 ปี";
        }
        
        
         $sqlHistory = "SELECT htr.remark,htr.historyId,htr.detailsId,htr.welfareId , htr.amount ,"
                . "htr.dateCreated,htr.dateUse,htr.memberId "
                . "FROM " . $parthWelfare . "History htr "
                . "where htr.detailsId = :detailsId And htr.memberId = :memberId And htr.welfareId = :welfareId ";

        $param = array("detailsId" => $detailsId,
            "memberId" => $memberId,
            "welfareId" => $welfareId);

        if ($dateBudget["endDate"] != "") {
            $sqlHistory .= "and htr.dateCreated between :startDate and :endDate ";
            $param["startDate"] = $dateBudget["startDate"];
            $param["endDate"] = $dateBudget["endDate"];
        }

        $objHistory = $this->datacontext->getObject($sqlHistory, $param);
     
        $i = 1;
        foreach ($objHistory as $key1 => $value1) {
            
            foreach ($value1 as $key2 => $value2) {
                $objHistory[$key1]["rowNo"] = $i;
              
                if (is_a($value2, "DateTime")) {
                    $Y = $value2->format('Y') + 543;
                    $objHistory[$key1][$key2] = $objHistory[$key1][$key2]->format('d-m-'.$Y);
                    
                }
            }
            $i++;
        }
        
       
        $total = 0;
        foreach ($objHistory as $key => $value) {
            $total += $value['amount'];
        }
        
       $objWelfare["totalBudget"] = number_format($total);

       $objWelfare["total"] = number_format($objWelfare['quantity'] - $total);
        
        
        return $objWelfare;
    }

}
