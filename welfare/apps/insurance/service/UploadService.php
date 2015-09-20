<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\insurance\interfaces\IUploadService;
use apps\insurance\entity\SSO;
use apps\taxonomy\entity\Taxonomy;
use apps\member\entity\Member;

class UploadService extends CServiceBase implements IUploadService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function sso($file) {
        $return = true;
        $csv = fopen($file['tmp_name'], "r");
        $arr = array();
        while (!feof($csv)) {
            array_push($arr, fgetcsv($csv));
        }
        fclose($csv);
        array_splice($arr, 0, 1);
        array_pop($arr);

        $uploaddir = './uploads/';
        $filename = 'sso' . date("YmdHis") . ".csv";
        $uploadfile = $uploaddir . $filename;
        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            chmod($uploadfile, 0777);
            $error = array();
            foreach ($arr as $key => $value) {
                $memberId = "";
                $idCard = str_replace(" ", "", $value[0]);
                $titleName = str_replace(" ", "", $value[1]);
                $fname = str_replace(" ", "", $value[2]);
                $lname = str_replace(" ", "", $value[3]);
                $department = str_replace(" ", "", $value[4]);
                $workStartDate = str_replace(" ", "", $value[5]);
                $hospital = str_replace(" ", "", $value[6]);
                $issuedDate = str_replace(" ", "", $value[7]);
                $expireDate = str_replace(" ", "", $value[8]);
                $member = new Member();
                $member->idCard = $idCard;
                $dataMember = $this->datacontext->getObject($member);
                if ($dataMember == NULL) {
                    array_push($error, array(
                        "idCard" => $idCard,
                        "titleName" => $titleName,
                        "fname" => $fname,
                        "lname" => $lname,
                        "department" => $department,
                        "workStartDate" => $workStartDate,
                        "hospital" => $hospital,
                        "issuedDate" => $issuedDate,
                        "expireDate" => $expireDate
                    ));
                } else {
                    $sso = new SSO();
                    $sso->memberId = $dataMember[0]->memberId;
                    $sso->idCard = $idCard;
                    $sso->hospital = $hospital;
                    $issuedDate = explode("-", $issuedDate);
                    $sso->issuedDate = new \DateTime(intval($issuedDate[2] - 543) . "-" . $issuedDate[1] . "-" . $issuedDate[0]);
                    $expireDate = explode("-", $expireDate);
                    $sso->expireDate = new \DateTime(intval($expireDate[2] - 543) . "-" . $expireDate[1] . "-" . $expireDate[0]);
                    $sso->filename = $filename;
                    if ($this->datacontext->saveObject($sso)) {
                        $return = true;
                    }
                }
            }
            if (count($error) > 0) {
                $return = $error;
            }
        } else {
            $return = "cantUpload";
            //$return = $uploadfile;
        }

        return $return;
    }



}
