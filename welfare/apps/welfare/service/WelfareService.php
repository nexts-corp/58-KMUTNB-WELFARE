<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IWelfareService;

use apps\common\entity\Welfare;
use apps\common\entity\WelfareSub;
use apps\common\entity\WelfareConditions;
use apps\common\entity\PositionsType;

class WelfareService extends CServiceBase implements IWelfareService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function save($data) {
        $data->dateStart = new \DateTime($data->dateStart);
        $data->dateEnd = new \DateTime($data->dateEnd);
        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function update($data) {
        if ($this->datacontext->updateObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function delete($welfareId) {
        $deletewel = new Welfare();
        $deletewel->setWelfareId($welfareId);
        //$delwelfare = $this->datacontext->getObject($deletewel)[0];

        if ($this->datacontext->removeObject($deletewel)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function saveconditions($data) {
        $data->dateStartWorking = new \DateTime($data->dateStartWorking);
        $data->dateEndWork = new \DateTime($data->dateEndWork);
        $welfareConditionsId = $data->welfareConditionsId;
         
        if ($welfareConditionsId == null) {
             //print_r("55555555555555555555555555");
            return $this->datacontext->saveObject($data);
           
        } else {
             //print_r("666666666666666666666666");
            return $this->datacontext->updateObject($data);
        }
    }

    public function viewSubListWel($welfareId) {
        $view = new CJView("welfare/sublistswel", CJViewType::HTML_VIEW_ENGINE);
        $filter = new WelfareSub();
        $filter->setWelfareId($welfareId);
        $welfare_sub = $this->datacontext->getObject($filter);
        $view->welfareId = $welfareId;
        $view->welfare = $welfare_sub;
        return $view;
    }

    public function viewAddSubwelfare($welfareId) {
        $view = new CJView("welfare/addSub", CJViewType::HTML_VIEW_ENGINE);
        $view->welfareId = $welfareId;
        return $view;
    }

    public function saveSub($data) {
        //print_r($data);
        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function updateSub($data) {
        if ($this->datacontext->updateObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function viewSearch($data) {
        $view = new CJView("welfare/lists", CJViewType::HTML_VIEW_ENGINE);

        $sql = "select wel from\\apps\\common\\entity\\Welfare wel "
                . " where wel.welfareName LIKE :name ";

        $view->welfare = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));
//        print_r($view->datas);
        return $view;
    }

    public function viewSearchsubwelfare($data) {
        $view = new CJView("welfare/sublistswel", CJViewType::HTML_VIEW_ENGINE);

        $sql = "select wels from\\apps\\common\\entity\\WelfareSub wels "
                . " where wels.welfareSubName LIKE :name ";

        $view->welfare = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));
//        print_r($view->datas);
        return $view;
    }

    public function deleteSub($welfareSubId) {
        print_r($welfareSubId);
        $deletewel = new WelfareSub();
        $deletewel->setWelfareSubId($welfareSubId);
        
        //$delwelfare = $this->datacontext->getObject($deletewel)[0];

        if ($this->datacontext->removeObject($deletewel)) {
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }
    

//put your code here
}
