<?php

namespace apps\qa\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\qa\interfaces\IMultiFileService;
use apps\qa\entity\MultiFile;

class MultiFileService extends CServiceBase implements IMultiFileService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function delete($id) {
        
    }

    public function save($file) {
     
       
        if ($file['name']) {
            if (!$file['error']) {
                $dateF = Date("Y-m-d");
                $timeF = Date("H-i-s");
                $fname = "file_". $dateF ."_".$timeF;
                $name = $fname."".md5(rand(001, 2999));
                $ext = explode('.',$file['name']);
                $filename = $name . '.' . $ext[1];
                
                $uploaddir = './uploads/qa/' . $filename;
                $tmp_name = $file['tmp_name'];
                $check= move_uploaded_file($tmp_name,$uploaddir);
              //chmod($tmp_name, 0777);
                
                $data =new MultiFile();
                $data->multiFileName=$filename;
                if($check){
                $this->datacontext->saveObject($data);
                }
            }
           
        }
        
        return $filename;
    }


    public function update($data) {
        
    }

}
    