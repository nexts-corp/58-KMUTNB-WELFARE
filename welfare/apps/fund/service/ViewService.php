<?php

namespace apps\fund\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\fund\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function cooperativeAdd() {
        
        $view = new CJView("cooperative/add", CJViewType::HTML_VIEW_ENGINE);
        return  $view;
        
    }

    public function detailsLists($id) {
        
       $view = new CJView("cooperative/adddetail", CJViewType::HTML_VIEW_ENGINE);
        return  $view;
    }

    public function cooperativeLists() {
        
        $view = new CJView("cooperative/lists", CJViewType::HTML_VIEW_ENGINE);
        return  $view;
    }

    public function fundAdd() {
        
    }

    public function fundEdit($id) {
        
    }

    public function fundLists() {
        
    }

    public function liveAdd() {
        
    }

    public function liveEdit($id) {
        
    }

    public function liveLists() {
        
    }

    public function policyAdd() {
        
    }

    public function policyEdit($id) {
        
    }

    public function policyLists() {
        
    }

    public function retireAdd($id) {
        
    }

    public function retireEdit($id) {
        
    }

    public function retireLists($id) {
        
    }

    

    // start serviec view academic

   

}
