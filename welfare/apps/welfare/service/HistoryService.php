<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IHistoryService;
use apps\welfare\entity\History;

class HistoryService extends CServiceBase implements IHistoryService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function preview($data) {

        $conditionsId = $data->conditionsId;
        $memberId = $data->memberId;

        $path = '\\apps\\taxonomy\\entity\\';
        $parthWelfare = '\\apps\\welfare\\entity\\';

        $sql = "SELECT cdt.amount,cdt.conditionsId,cdt.welfareId, cdt.description ,"
                . "wf.welfareId , wf.name , "
                . "wf.description As wfDescription, wf.dateStart, "
                . "wf.resetTime , wf.dateEnd , wf.free , "
                . "un.id As unitId , un.value1 As unitValue  "
                . "FROM " . $parthWelfare . "Conditions cdt "
                . "Left JOIN " . $parthWelfare . "Welfare wf "
                . "with cdt.welfareId = wf.welfareId "
                . "Left JOIN " . $path . " Taxonomy  un  "
                . "with cdt.returnTypeId = un.id "
                . "where cdt.conditionsId = :conditionsId";


        $objWelfare = $this->datacontext->getObject($sql, array("conditionsId" => $conditionsId))[0];

        foreach ($objWelfare as $key => $value) {
            if (is_a($value,"DateTime")) {
                $Y=$value->format('Y')+543;
                $objWelfare[$key] = $value->format('d-m-'.$Y.'');
            }
        }
        
        
//        $sqlHistory = "SELECT  htr.amount,htr.conditionsId,htr.memberId,htr.welfareId";
//        
//        
//        $objWelfare = $this->datacontext->getObject($sql, array("conditionsId" => $conditionsId));
        
        
        return true;
    }

}
