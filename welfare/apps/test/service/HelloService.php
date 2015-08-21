<?php

namespace apps\test\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\data\CDataContext;
use apps\test\interfaces\IHelloService;
use apps\test\model\Customer;

class HelloService extends CServiceBase implements IHelloService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function hello($name) {
        return "Hello : " . $name;
    }

    public function add($x, $y) {
        return $x + $y;
    }

 public function getCusById($id) {
       $filter=new Customer();
        $filter->setId($id);
        return $this->datacontext->getObject($filter)[0];
    }

    public function customers() {

        //#1
        //return $this->datacontext->getObject(new Customer());
        //#2
        //$sql="select p from apps\\pongpanot\\entity\\Customer p";
        //return $this->datacontext->getObject($sql);
        //#3
        //$filter=new Customer();
        //$filter->setId(2);
        //return $this->datacontext->getObject($filter);
        //#4
        //$sql="select p.name from apps\\pongpanot\\entity\\Customer p where p.id=:id";
        //return $this->datacontext->getObject($sql,array("id"=>1));
        //#5
        return $this->datacontext->getObject(new Customer(), null);
    }
    
    public function addCustomer($name,$address) {
        $cus = new Customer();
        $cus->setName($name);
        $cus->setAddress($address);
        if($this->datacontext->saveObject($cus)){
            return true;
        }else{
            return false;
        }
    }

    public function updateCustomer($id,$name) {
        $cus = new Customer();
        $cus->setId($id);
        $cus->setName($name);
        if($this->datacontext->updateObject($cus)){
            return true;
        }
        else{
            return false;
        }
    }

    public function delCustomer($id) {
        $cus = new Customer();
        $cus->setId(intval($id));
        if($this->datacontext->removeObject($cus)){
            
            return true;
        }else{
            echo $this->datacontext->getLastMessage();
            return false;
        }
    }
    
    public function view() {
        $view = new CJView("list", CJViewType::HTML_VIEW_ENGINE);
        $view->cuss = $this->customers();
        return $view;
    }
    
     public function viewAdd() {
        $view = new CJView("add", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
     public function viewEdit($id) {
        $view = new CJView("edit", CJViewType::HTML_VIEW_ENGINE);
        $view->cus = $this->getCusById($id);
        return $view;
    }

    public function viewHello() {
        $view = new CJView("hello", CJViewType::HTML_VIEW_ENGINE);
        return $view; 
    }


    
    

}
