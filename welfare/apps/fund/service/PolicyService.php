<?php
namespace apps\ManagementFund\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\ManagementFund\interfaces\IPolicyService;
use apps\common\entity\Policy;

class PolicyService extends CServiceBase implements IPolicyService{
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }           
    
    public function viewList() {
        $view = new CJView("policy/list", CJViewType::HTML_VIEW_ENGINE);
        $listPolicy = new Policy();
        $Policy = $this->datacontext->getObject($listPolicy);

        $view->list = $Policy;
        
        return  $view;
    }

    public function viewAdd() {
        $view = new CJView("policy/add", CJViewType::HTML_VIEW_ENGINE);
        
        return  $view;
    }

    public function save($data) {
        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }
    
    public function viewEdit($policyId) {
        $view = new CJView("policy/edit", CJViewType::HTML_VIEW_ENGINE);
        $editPolicy = new Policy();
        $editPolicy->setPolicyId($policyId);
        $Policy = $this->datacontext->getObject($editPolicy);
        $view->policyId = $policyId;
        $view->edit = $Policy;
        return  $view;
    }
    
    public function update($data) {
        if ($this->datacontext->updateObject($data)) {
           
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function viewSearch($data) {
        $view = new CJView("policy/list", CJViewType::HTML_VIEW_ENGINE);
        $path = '\\apps\\common\\entity\\';

        $sql = "SELECT  pol "
                . "FROM ". $path ."Policy pol "
                . " where pol.policyname LIKE :name or pol.policydetail LIKE :name ";

        $view->list = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));
//        print_r($sql);
        return $view;
    }

//put your code here
}
