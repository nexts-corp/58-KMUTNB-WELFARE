<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\insurance\interfaces\IUploadService;
use apps\insurance\entity\Insurance;
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
        $filename = 'sso' . date("YmdHis").".csv";
        $uploadfile = $uploaddir . $filename;
        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            chmod($uploadfile, 0777);
            foreach ($arr as $key => $value) {
                $memberId = "";
                $idCard = str_replace(" ","",$value[0]);
                $titleName = str_replace(" ","",$value[1]);
                $fname = str_replace(" ","",$value[2]);
                $lname = str_replace(" ","",$value[3]);
                $department = str_replace(" ","",$value[4]);
                $workStartDate = str_replace(" ","",$value[5]);
                $hospital = str_replace(" ","",$value[6]);
                $issuedDate = str_replace(" ","",$value[7]);
                $expireDate = str_replace(" ","",$value[8]);
                $member = new Member();
                $member->idCard = $idCard;
                $dataMember = $this->datacontext->getObject($member);
                if ($dataMember == NULL) {
                    $taxTitle = new Taxonomy();
                    $taxTitle->pCode = "titleName";
                    $taxTitle->value1 = $titleName;
                    $dataTitle = $this->datacontext->getObject($taxTitle)[0];

                    $taxActive = new Taxonomy();
                    $taxActive->pCode = "memberActive";
                    $taxActive->code = "working";
                    $dataActive = $this->datacontext->getObject($taxActive)[0];
                    
                    $taxDep = new Taxonomy();
                    $taxDep->value1 = $department;
                    $dataDep = $this->datacontext->getObject($taxDep)[0];
                    
                    $taxFac = new Taxonomy();
                    $taxFac->code = $dataDep->pCode;
                    $dataFac = $this->datacontext->getObject($taxFac)[0];
                    
                    $member->titleId = $dataTitle->id;
                    $member->fname = $fname;
                    $member->lname = $lname;
                    $member->departmentId = $dataDep->id;
                    $member->facultyId = $dataFac->id;
                    $workStartDate = explode("-", $workStartDate);
                    $member->workStartDate = new \DateTime(intval($workStartDate[2] - 543) . "-" . $workStartDate[1] . "-" . $workStartDate[0]);
                    $member->memberActiveId = $dataActive->id;
                    $this->datacontext->saveObject($member);

                    $memberId = $member->memberId;
                } else {
                    $memberId = $dataMember[0]->memberId;
                }

                $insurance = new Insurance();
                $insurance->memberId = $memberId;
                $insurance->idCard = $idCard;
                $insurance->hospital = $hospital;
                $issuedDate = explode("-", $issuedDate);
                $insurance->issuedDate = new \DateTime(intval($issuedDate[2] - 543) . "-" . $issuedDate[1] . "-" . $issuedDate[0]);
                $expireDate = explode("-", $expireDate);
                $insurance->expireDate = new \DateTime(intval($expireDate[2] - 543) . "-" . $expireDate[1] . "-" . $expireDate[0]);
                $insurance->filename = $filename;
                if ($this->datacontext->saveObject($insurance)) {
                    $return = true;
                } else {
                    return $this->datacontext->getLastMessage();
                }
            }
        } else {
            $return = "cantUpload";
            //$return = $uploadfile;
        }
        
        return $return;
    }

}
