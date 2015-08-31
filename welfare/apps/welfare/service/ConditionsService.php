<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IConditionsService;
use apps\welfare\entity\Conditions;

class ConditionsService extends CServiceBase implements IConditionsService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function delete($Id) {
        
    }

    public function save($data) {
        foreach ($data as $key => $value) {
            if ($data[$key]->dateStartWork != "") {
                $data[$key]->dateStartWork = new \DateTime($data[$key]->dateStartWork);
            }
            if ($data[$key]->dateEndWork != "") {
                $data[$key]->dateEndWork = new \DateTime($data[$key]->dateEndWork);
            }
        }
        return $this->datacontext->saveObject($data);
//       $return = true;
//        $emp = $data->employeeTypeId;
////        //print count($emp)." ....";
//        for ($i = 0; $i < count($emp); $i++) {
//            //print $emp[$i];
//            if ($data->dateStartWork != "") {
//                $data->dateStartWork = new \DateTime($data->dateStartWork);
//            }
//            if ($data->dateEndWork != "") {
//                $data->dateEndWork = new \DateTime($data->dateEndWork);
//            }
//
//            $data->employeeTypeId = $emp[$i];
//            if (!$this->datacontext->saveObject($data)) {
//                $return = $this->datacontext->getLastMessage();
//            }
//           // print_r($data);
//        }
//            if($this->datacontext->saveObject($data)){
//                return true;
//            }else{
//                return false;
//            }
//         if (count($data->employeeTypeId) > 0) {
//             
//            foreach ($obj as $key => $value) {
//                $obj[$key]->employeeTypeId = $value->employeeTypeId;
//             
//                $data->employeeTypeId=$obj;
//                $this->datacontext->saveObject($data);
//
//            }
    }

    public function update($data) {
        
    }

}
