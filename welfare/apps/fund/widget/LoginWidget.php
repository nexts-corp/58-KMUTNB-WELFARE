<?php
namespace apps\sdg\widget;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginWidget extends \th\co\bpg\cde\core\CWidget{
    
    var $datacontext;
    function __construct() {
      //  $this->datacontext=new \th\co\bpg\cde\data\CDataContext(NULL);
    }

    public function render() {
        
        $file = new \th\co\bpg\cde\collection\CJView("login",
                 \th\co\bpg\cde\collection\CJViewType::HTML_VIEW_ENGINE);
        $file->name="socmhit";
        $file->surname="chanudom";
        return $file;
      //  print_r($this->getRequest());
      //  return "Hello simple widget";
    }

}