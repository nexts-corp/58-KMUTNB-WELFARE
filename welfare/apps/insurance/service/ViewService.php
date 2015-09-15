<?php

namespace apps\insurance\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\insurance\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function insuranceAdd() {
        $view = new CJView("insurance/add", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function insuranceList() {

        $view = new CJView("insurance/lists", CJViewType::HTML_VIEW_ENGINE);
        $path = '\\apps\\common\\entity\\';

        $sql = "SELECT aca.academicPositionsNameTh,ra.rankNameTh,tit.titleNameTh,reg.registerId, reg.registerNameTh,reg.registerLastNameTh,de.departmentNameTh,"
                . "ins.hospitalname,ins.datestart,ins.dateend "
                . "FROM " . $path . "Register reg "
                . "LEFT JOIN " . $path . "AcademicPositions aca with "
                . "reg.academicPositionsId = aca.academicPositionsId "
                . "LEFT JOIN " . $path . "Rank ra with reg.rankId = ra.rankId "
                . "LEFT JOIN " . $path . "Titlename tit with tit.titleNameId = reg.titleNameId "
                . "LEFT join  " . $path . "department de with de.departmentId = reg.departmentId "
                . "INNER join  " . $path . "Insurance ins with ins.registerIdCard = reg.registerIdCard "
                . "ORDER BY reg.registerId DESC";
        $member = $this->datacontext->getObject($sql);
        if ($member != null) {

            $datestart = $member[0]['datestart']->format('d-m-Y');
            $dateend = $member[0]['dateend']->format('d-m-Y');
            //print_r($member);
            $view->datestarts = $datestart;
            $view->dateends = $dateend;
            $view->member = $member;
            return $view;
        } else {
            $view->member = $member;
            return $view;
        }
    }

    public function Privilegedetail($registerId) {
        $view = new CJView("privilege/privilege", CJViewType::HTML_VIEW_ENGINE);
        $path = '\\apps\\common\\entity\\';

        $sql = "SELECT aca.academicPositionsNameTh,ra.rankNameTh,tit.titleNameTh,fam.familyId,fam.familyName,fam.familyLastName,fam.familyStatusReraTion,pri.ratio "
                . "FROM " . $path . "Family fam "
                . "LEFT JOIN " . $path . "AcademicPositions aca with "
                . "fam.academicPositionsId = fam.academicPositionsId "
                . "LEFT JOIN " . $path . "Rank ra with fam.rankId = ra.rankId "
                . "LEFT JOIN " . $path . "Titlename tit with tit.titleNameId = fam.titleNameId "
                . "INNER JOIN " . $path . "Privileges pri with pri.familyId = fam.familyId "
                . "where fam.registerId =" . $registerId . " GROUP BY fam.familyId ";

        $listfa = $this->datacontext->getObject($sql);
        //print_r($listfa);
        $view->register = $registerId;
        $view->famaily = $listfa;

        return $view;
    }

    public function privilegeAdd($registerId) {
        $view = new CJView("privilege/add", CJViewType::HTML_VIEW_ENGINE);
        $path = '\\apps\\common\\entity\\';

        $sql = "SELECT aca.academicPositionsNameTh,ra.rankNameTh,tit.titleNameTh,fam.familyId,fam.familyName,fam.familyLastName,fam.familyStatusReraTion "
                . "FROM " . $path . "Family fam "
                . "LEFT JOIN " . $path . "AcademicPositions aca with "
                . "fam.academicPositionsId = fam.academicPositionsId "
                . "LEFT JOIN " . $path . "Rank ra with fam.rankId = ra.rankId "
                . "LEFT JOIN " . $path . "Titlename tit with tit.titleNameId = fam.titleNameId "
                . "where fam.registerId =" . $registerId . " GROUP BY fam.familyId ";

        $listfa = $this->datacontext->getObject($sql);
        //print_r($listfa);
        $view->register = $registerId;
        $view->listfamaily = $listfa;

        return $view;
    }

    public function privilegeEdit($familyId) {
        $view = new CJView("privilege/edit", CJViewType::HTML_VIEW_ENGINE);
        $path = '\\apps\\common\\entity\\';

        $sql = "SELECT aca.academicPositionsNameTh,ra.rankNameTh,tit.titleNameTh,fam.familyId,fam.familyName,fam.familyLastName,fam.familyStatusReraTion,pri.ratio,pri.privilegeId,pri.registerId "
                . "FROM " . $path . "Family fam "
                . "LEFT JOIN " . $path . "AcademicPositions aca with fam.academicPositionsId = fam.academicPositionsId "
                . "LEFT JOIN " . $path . "Rank ra with fam.rankId = ra.rankId "
                . "LEFT JOIN " . $path . "Titlename tit with tit.titleNameId = fam.titleNameId "
                . "INNER JOIN " . $path . "Privileges pri with pri.familyId = fam.familyId "
                . "where fam.familyId =" . $familyId . " GROUP BY fam.familyId";
        //print_r($sql);
        $listfa = $this->datacontext->getObject($sql);
        $view->listfamaily = $listfa;
        return $view;
    }

    public function privilegeList() {
        $usertype = $this->getCurrentUser()->usertype;
        $facultyId = $this->getCurrentUser()->attribute->facultyId;
        $departmentId = $this->getCurrentUser()->attribute->departmentId;
        $searchName = $this->getRequest()->searchName;
        $param = array();
        $sql = "select (tax1.value1) As titlename,mem1.fname,mem1.lname,mem1.idCard,mem1.memberId,(tax3.value1) as faculty,(tax4.value1) as department "
                . "FROM apps\\member\\entity\\Member mem1 "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax1 "
                . "with mem1.titleId = tax1.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax2 "
                . "with mem1.memberActiveId = tax2.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax3 "
                . "with mem1.facultyId = tax3.id "
                . "INNER JOIN apps\\taxonomy\\entity\\Taxonomy tax4 "
                . "with mem1.departmentId = tax4.id "
                . "WHERE tax2.pCode = 'memberActive' and tax2.code = 'working' ";

        if ($usertype == "administrator") {
            $view = new CJView("privilege/lists", CJViewType::HTML_VIEW_ENGINE);
        } elseif ($usertype == "adminFaculty") {
            $view = new CJView("privilege/lists", CJViewType::HTML_VIEW_ENGINE);

            $sql .= " and tax3.code = :facultyId "; //กรณีที่ไม่ได้ search
            $param["facultyId"] = $facultyId;
        } elseif ($usertype == "adminDepartment") {
            $view = new CJView("privilege/lists", CJViewType::HTML_VIEW_ENGINE);

            $sql .= " and tax4.code = :departmentId "; //กรณีที่ไม่ได้ search
            $param["departmentId"] = $departmentId;
        }

        if ($searchName != "") {
            $search = new \apps\member\service\MemberService();
            $view->lists = $search->search($searchName);
        } else {
            $view->lists = $this->datacontext->getObject($sql, $param); //กรณีที่ไม่ได้ search
        }
        return $view;
    }

    public function socialsecurityList() {
        $view = new CJView("socialSecurity/lists", CJViewType::HTML_VIEW_ENGINE);
//        $filter = new AcademicPositions();
//        $dao_department = $this->datacontext->getObject($filter);
//        $view->cuss = $dao_department;
        return $view;
    }

}
