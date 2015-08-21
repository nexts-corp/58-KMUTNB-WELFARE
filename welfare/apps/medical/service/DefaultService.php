<?php
namespace apps\medical\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;

use apps\medical\interfaces\IDefaultService;
use apps\common\entity\SettingMedicalFee;

class DefaultService extends CServiceBase implements IDefaultService{
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    

    public function save($data) {
         $SettingMedicalFeeId = $data->SettingMedicalFeeId;
        if ($SettingMedicalFeeId == null){
            return $this->datacontext->saveObject($data);
        }  else {
            return $this->datacontext->updateObject($data);
        }
    }

}
