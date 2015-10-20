<?php

namespace apps\fund\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\taxonomy\service\TaxonomyService;
use apps\fund\interfaces\IUploadService;
use apps\taxonomy\entity\Taxonomy;
use apps\member\entity\Member;

class UploadService extends CServiceBase implements IUploadService {

    public $datacontext;
    public $taxonomy;

    function __construct() {
        $this->datacontext = new CDataContext();
        $this->taxonomy = new TaxonomyService();
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

        $uploaddir = './uploads/fund/';
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

    public function extra($file) {
        $return = true;
        $csv = fopen($file['tmp_name'], "r");
        $arr = array();
        while (!feof($csv)) {
            array_push($arr, fgetcsv($csv));
        }
        fclose($csv);
        array_splice($arr, 0, 1);
        array_pop($arr);

        $uploaddir = './uploads/fund/';
        $filename = 'fundEx' . date("YmdHis") . ".csv";
        $uploadfile = $uploaddir . $filename;


        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            chmod($uploadfile, 0777);
            $error = array();

            $tax = new Taxonomy();
            $tax->pCode = "fundType";
            $tax->code = "fundType-extra";
            $fundType = $this->datacontext->getObject($tax)[0];

            $tax = new Taxonomy();
            $tax->pCode = "employeeType";
            $tax->code = "extra";
            $employeeEx = $this->datacontext->getObject($tax)[0];

            $tax = new Taxonomy();
            $tax->pCode = "employeeType";
            $tax->code = "government";
            $employeeGo = $this->datacontext->getObject($tax)[0];

            foreach ($arr as $key => $value) {
                $idCard = str_replace(" ", "", $value[0]);
                $fname = str_replace(" ", "", $value[1]);
                $lname = str_replace(" ", "", $value[2]);
                $dateNotice = str_replace(" ", "", $value[3]);
                $dateNotice = explode("-", $dateNotice);
                $dateNotice = new \DateTime(intval($dateNotice[2] - 543) . "-" . $dateNotice[1] . "-" . $dateNotice[0]);
                $policy = $value[4];
                $saving = str_replace(",", "", str_replace(" ", "", $value[5]));
                $grantInAid = str_replace(",", "", str_replace(" ", "", $value[6]));
                $total = str_replace(",", "", str_replace(" ", "", $value[7]));

                $member = "select mb "
                        . "from apps\\member\\model\\Member mb "
                        . "where ( mb.employeeTypeId = :employeeEx "
                        . " or mb.employeeTypeId = :employeeGo ) "
                        . " and mb.idCard = :idCard ";
                $param = array(
                    "employeeEx" => $employeeEx->id,
                    "employeeGo" => $employeeGo->id,
                    "idCard" => $idCard
                );
                $dataMember = $this->datacontext->getObject($member, $param);
                if (count($dataMember) == 0) {
                    array_push($error, array(
                        "idCard" => $idCard,
                        "fname" => $fname,
                        "lname" => $lname,
                        "saving" => $saving,
                        "grantInAid" => $grantInAid,
                        "total" => $total,
                        "dateNotice" => $value[3]
                    ));
                } else {
                    $pol = new \apps\fund\entity\Policy();
                    $pol->name = $policy;
                    $pol->fundTypeId = $fundType->id;
                    $dataPol = $this->datacontext->getObject($pol);

                    $employee = new \apps\fund\entity\FundExtra();
                    if (count($dataPol) > 0) {
                        $employee->policyId = $dataPol[0]->policyId;
                    }
                    $employee->memberId = $dataMember[0]->memberId;
                    //  $employee->idCard = $idCard;
                    $employee->saving = $saving;
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

    public function retire($file) {
        $return = true;
        $csv = fopen($file['tmp_name'], "r");
        $arr = array();
        while (!feof($csv)) {
            array_push($arr, fgetcsv($csv));
        }
        fclose($csv);
        array_splice($arr, 0, 1);
        array_pop($arr);

        $uploaddir = './uploads/fund/';
        $filename = 'fundRe' . date("YmdHis") . ".csv";
        $uploadfile = $uploaddir . $filename;


        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            chmod($uploadfile, 0777);
            $error = array();

            $tax = new Taxonomy();
            $tax->pCode = "fundType";
            $tax->code = "fundType-retire";
            $fundType = $this->datacontext->getObject($tax)[0];

            $tax = new Taxonomy();
            $tax->pCode = "employeeType";
            $tax->code = "retire";
            $employeeRe = $this->datacontext->getObject($tax)[0];


            foreach ($arr as $key => $value) {
                $idCard = str_replace(" ", "", $value[0]);
                $fname = str_replace(" ", "", $value[1]);
                $lname = str_replace(" ", "", $value[2]);
                $dateNotice = str_replace(" ", "", $value[3]);
                $dateNotice = explode("-", $dateNotice);
                $dateNotice = new \DateTime(intval($dateNotice[2] - 543) . "-" . $dateNotice[1] . "-" . $dateNotice[0]);
                $policy = $value[4];
                $saving = str_replace(",", "", str_replace(" ", "", $value[5]));
                $grantInAid = str_replace(",", "", str_replace(" ", "", $value[6]));
                $total = str_replace(",", "", str_replace(" ", "", $value[7]));

                $member = new \apps\member\model\Member();
                $member->idCard = $idCard;
                $member->employeeTypeId = $employeeRe->id;
                $dataMember = $this->datacontext->getObject($member);
                if (count($dataMember) == 0) {
                    array_push($error, array(
                        "idCard" => $idCard,
                        "fname" => $fname,
                        "lname" => $lname,
                        "saving" => $saving,
                        "grantInAid" => $grantInAid,
                        "total" => $total,
                        "dateNotice" => $value[3]
                    ));
                } else {
                    $pol = new \apps\fund\entity\Policy();
                    $pol->name = $policy;
                    $pol->fundTypeId = $fundType->id;
                    $dataPol = $this->datacontext->getObject($pol);

                    $employee = new \apps\fund\entity\FundRetire();
                    if (count($dataPol) > 0) {
                        $employee->policyId = $dataPol[0]->policyId;
                    }
                    $employee->memberId = $dataMember[0]->memberId;
                    //  $employee->idCard = $idCard;
                    $employee->saving = $saving;
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
