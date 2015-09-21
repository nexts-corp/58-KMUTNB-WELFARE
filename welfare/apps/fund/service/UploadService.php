<?php

namespace apps\fund\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\fund\interfaces\IUploadService;
use apps\taxonomy\entity\Taxonomy;
use apps\member\entity\Member;

class UploadService extends CServiceBase implements IUploadService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function employee($file) {
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
        $filename = 'fundEmp' . date("YmdHis") . ".csv";
        $uploadfile = $uploaddir . $filename;


        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            chmod($uploadfile, 0777);
            $error = array();

            $tax = new Taxonomy();
            $tax->pCode = "fundType";
            $tax->code = "fundType-employee";
            $fundType = $this->datacontext->getObject($tax)[0];

            $tax = new Taxonomy();
            $tax->pCode = "employeeType";
            $tax->code = "employee";
            $employeeType = $this->datacontext->getObject($tax)[0];
            foreach ($arr as $key => $value) {

                $idCard = str_replace(" ", "", $value[0]);
                $fname = str_replace(" ", "", $value[1]);
                $lname = str_replace(" ", "", $value[2]);
                $dateNotice = str_replace(" ", "", $value[3]);
                $dateNotice = explode("-", $dateNotice);
                $dateNotice = new \DateTime(intval($dateNotice[2] - 543) . "-" . $dateNotice[1] . "-" . $dateNotice[0]);
                $policy = $value[4];
                $saving = str_replace(",", "", str_replace(" ", "", $value[5]));
                $myBenefit = str_replace(",", "", str_replace(" ", "", $value[6]));
                $employerBenefit = str_replace(",", "", str_replace(" ", "", $value[7]));
                $grantInAid = str_replace(",", "", str_replace(" ", "", $value[8]));
                $total = str_replace(",", "", str_replace(" ", "", $value[9]));

                $member = new \apps\member\model\FullMember();
                $member->idCard = $idCard;
                $member->employeeTypeId = $employeeType->id;
                $dataMember = $this->datacontext->getObject($member);
                if (count($dataMember) == 0) {
                    array_push($error, array(
                        "idCard" => $idCard,
                        "fname" => $fname,
                        "lname" => $lname,
                        "saving" => $saving,
                        "myBenefit" => $myBenefit,
                        "employerBenefit" => $employerBenefit,
                        "grantInAid" => $grantInAid,
                        "total" => $total,
                        "dateNotice" => $value[3]
                    ));
                } else {

                    $pol = new \apps\fund\entity\Policy();
                    $pol->name = $policy;
                    $pol->fundTypeId = $fundType->id;
                    $dataPol = $this->datacontext->getObject($pol);

                    $employee = new \apps\fund\entity\FundEmployee();
                    if (count($dataPol) > 0) {
                        $employee->policyId = $dataPol[0]->policyId;
                    }
                    $employee->memberId = $dataMember[0]->memberId;
                    $employee->idCard = $idCard;
                    $employee->saving = $saving;
                    $employee->myBenefit = $myBenefit;
                    $employee->employerBenefit = $employerBenefit;
                    $employee->grantInAid = $grantInAid;
                    $employee->total = $total;
                    $employee->dateNotice = $dateNotice;
                    $employee->filename = $filename;
                    if ($this->datacontext->saveObject($employee)) {
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
