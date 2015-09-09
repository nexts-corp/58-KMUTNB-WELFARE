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
        
    }

    public function cooperativeLists() {
        $view = new CJView("cooperative/lists", CJViewType::HTML_VIEW_ENGINE);
        return $view;
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
        $view = new CJView("fundlive/lists", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function policyAdd() {
        $view = new CJView("policy/add", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function policyEdit($id) {
        
    }

    public function policyLists() {
        $view = new CJView("policy/lists", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function retireAdd($id) {
        
    }

    public function retireEdit($id) {
        
    }

    public function retireLists() {
        $view = new CJView("fundretire/lists", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
