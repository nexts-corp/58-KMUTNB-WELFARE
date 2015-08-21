<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\insurance\interfaces\IInsuranceService;

class InsuranceService extends CServiceBase implements IInsuranceService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }
    

    public function viewSearch($data) {
        $view = new CJView("insurance/add", CJViewType::HTML_VIEW_ENGINE);
        $path = '\\apps\\common\\entity\\';


        $sql = "SELECT reg FROM " . $path . "Register reg "
                . " where reg.registerIdCard LIKE :name ";

        $view->member = $this->datacontext->getObject($sql, array("name" => "%" . $data . "%"));
//        print_r($view->datas);
        return $view;
    }

    public function save($data) {
        $data->datestart = new \DateTime($data->datestart);
        $data->dateend = new \DateTime($data->dateend);
        if ($this->datacontext->saveObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return $data;
        }
    }

    public function viewSearchlist($data) {
        $view = new CJView("insurance/lists", CJViewType::HTML_VIEW_ENGINE);
        $path = '\\apps\\common\\entity\\';


        $sql = "SELECT aca.academicPositionsNameTh,ra.rankNameTh,tit.titleNameTh,reg.registerId, reg.registerNameTh,reg.registerLastNameTh,de.departmentNameTh,"
                . "ins.hospitalname,ins.datestart,ins.dateend "
                . "FROM " . $path . "Register reg "
                . "LEFT JOIN " . $path . "AcademicPositions aca with "
                . "reg.academicPositionsId = aca.academicPositionsId "
                . "LEFT JOIN " . $path . "Rank ra with reg.rankId = ra.rankId "
                . "LEFT JOIN " . $path . "Titlename tit with tit.titleNameId = reg.titleNameId "
                . "INNER join  " . $path . "department de with de.departmentId = reg.departmentId "
                . "INNER join  " . $path . "Insurance ins with ins.registerIdCard = reg.registerIdCard "
                . " where reg.registerIdCard LIKE :name ";

        $member = $this->datacontext->getObject($sql, array("name" => "%".$data ."%"));
        if ($member==null){
            return $view;
        }else {
            $datestart = $member[0]['datestart']->format('d-m-Y');
            $dateend = $member[0]['dateend']->format('d-m-Y');

            $view->datestarts = $datestart;
            $view->dateends = $dateend;
            $view->member = $member;
//        print_r($view->datas);
            return $view;
        }
        
    }

//put your code here
}
