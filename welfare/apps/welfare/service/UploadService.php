<?php

namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\welfare\interfaces\IUploadService;
use apps\taxonomy\entity\Taxonomy;
use apps\member\entity\Member;

class UploadService extends CServiceBase implements IUploadService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function welfare($file) {
        $return = true;
        $uploaddir = './uploads/welfare/';
        $filename = 'welfare' . date("YmdHis");
        $typefile = explode(".", $file["name"]);
        $filename = $filename . "." . $typefile[count($typefile) - 1];
        $uploadfile = $uploaddir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            chmod($uploadfile, 0777);
            $return = $filename;
        } else {
            $return = "cantUpload";
        }

        return $return;
    }

}
