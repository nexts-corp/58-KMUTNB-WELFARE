<?php
namespace apps\welfare\service;
use apps\common\entity\Register;
use apps\common\entity\WelfareConditions;
use apps\common\entity\WelfareRights;
use apps\common\entity\WelfareSub;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\common\entity\Welfare;

use apps\welfare\interfaces\IWelfareClaimsService;

class WelfareClaimsService extends CServiceBase implements IWelfareClaimsService{
    
    public $datacontext;
    public $entity = "apps\\common\\entity\\";
    
    function __construct() {
        $this->datacontext = new CDataContext();
    }
 

    public function add($registerId,$welfareSubId) {

        $wel = new WelfareSub();
        $wel->setWelfareSubId($welfareSubId);
        $data = $this->datacontext->getObject($wel);

//        $dt = new \DateTime();
//        $dt->format('Y-m-d H:i:s');


        $wel_right = new WelfareRights();

        $wel_right->setWelfareId($data[0]->welfareId);
        $wel_right->setRegisterId($registerId);
        $wel_right->setAmount($data[0]->amount);
        $wel_right->setDateStartWelfare(new \DateTime());
        $wel_right->setStatusId('1');
        //return new \DateTime();
        return $this->datacontext->saveObject($wel_right);
    }


    

    public function approve($welfareRightsId) {

        $sql = "UPDATE welfarerights SET statusId = 2 WHERE welfareRightsId = ".$welfareRightsId;

        $info = $this->datacontext->pdoQuery($sql);
        if($info){
            return $info;
        }
        return NULL;

    }


    public function unapproved($welfareRightsId) {

        $sql = "UPDATE welfarerights SET statusId = 3 WHERE welfareRightsId = ".$welfareRightsId;

        $info = $this->datacontext->pdoQuery($sql);
        if($info){
            return $info;
        }
        return NULL;
    }



    public function welfareDetails($welfareId) {

        $user = new WelfareConditions();
        $user->setWelfareConditionsId($welfareId);
        // $user->setRegisterPosision()
        //$user_info = ;

        $datas = $this->datacontext->getObject($user);

        //$fee = new MedicalFee();
        $path = '\\apps\\common\\entity\\';

        //$setting = new SettingMedicalFee();
        $sql = "SELECT wc.welfareSubId FROM ".$path."welfareconditions wc WHERE wc.welfareConditionsId = ".$datas[0]->welfareSubId;
        $set_am = $this->datacontext->getObject($sql);
        if($datas){
            $sql="SELECT sum(m.amount) as aa FROM ".$path."MedicalFee m WHERE m.registerId = '".$datas[0]->registerId."'";
            $amount = $this->datacontext->getObject($sql);

            $arr = array(
                'user'=> $datas[0],
                'amount'=> $set_am[0]['amountSetting']-$amount[0]['aa']//$amount
            );
            return $arr;
        }


        return NULL;

    }



}
