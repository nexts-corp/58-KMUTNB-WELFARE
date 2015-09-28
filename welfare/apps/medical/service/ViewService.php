<?php

namespace apps\medical\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use \apps\medical\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }

    public function medicalFeeAdd() {
        $view = new CJView("medicalfee/add", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function medicalFeeLists() {
        $view = new CJView("medicalfee/lists", CJViewType::HTML_VIEW_ENGINE);

        $searchName = $this->getRequest()->searchName;
        $filterCode = $this->getRequest()->filterCode;
        $filtervalue = $this->getRequest()->filtervalue;
        $datafilter = $this->getRequest();

        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->setCode("medical001");
        $query = $this->datacontext->getObject($welfare)[0];

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $query->welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];

        $dateStart = $dateBudget["startDate"];
        $dateEnd = $dateBudget["endDate"];

        $sql1 = "select mb.fname,mb.lname,whis.welfareId,wc.conditionsId,whis.memberId,wd.quantity,mb.idCard,mb.department1,mb.faculty1,"
                . "sum(whis.amount) as payment,wd.quantity-sum(whis.amount) as balance, "
                . "IFNULL(mb.academic1,mb.titleName1) title "
                . "from welfarehistory whis "
                . "join welfaredetails wd "
                . "on wd.detailsId = whis.detailsId "
                . "join welfare wel "
                . "on wel.welfareId = whis.welfareId and wel.code = 'medical001' "
                . "join welfareconditions wc "
                . "on wc.detailsId = wd.detailsId "
                . "join v_fullmember mb "
                . "on mb.memberId = whis.memberId and mb.employeeTypeId = wc.valuex and wc.fieldMap = 'employeeTypeId' "
                . "where whis.dateCreated between :dateStart and :dateEnd "
                . "group by whis.memberId ";

        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd
        );


        if ($searchName != "") {

            $search = new MedicalFeeService();
            $view->lists = $search->search($datafilter);
        } else if ($filterCode != "") {

            $filter = new MedicalFeeService();
            $view->lists = $filter->search($datafilter);
        } else {
            $budget = $this->datacontext->pdoQuery($sql1, $param);
            $view->lists = $budget; //กรณีที่ไม่ได้ search //กรณีที่ไม่ได้ search
        }

        return $view;
    }

    public function medicalFeedetails($memberId) {
        $view = new CJView("medicalfee/details", CJViewType::HTML_VIEW_ENGINE);

        $searchName = $this->getRequest()->searchName;
        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->setCode("medical001");
        $query = $this->datacontext->getObject($welfare)[0];

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $query->welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];

        $dateStart = $dateBudget["startDate"];
        $dateEnd = $dateBudget["endDate"];

        

        $sql1 = "select mb.fname,mb.lname,whis.welfareId,wc.conditionsId,whis.memberId,wd.quantity,mb.idCard,mb.department1,mb.faculty1,"
                . "whis.remark,whis.dateCreated,whis.dateUpdated,whis.historyId,whis.amount, "
                . "IFNULL(mb.academic1,mb.titleName1) title "
                . "from welfarehistory whis "
                . "join welfaredetails wd "
                . "on wd.detailsId = whis.detailsId "
                . "join welfare wel "
                . "on wel.welfareId = whis.welfareId and wel.code = 'medical001' "
                . "join welfareconditions wc "
                . "on wc.detailsId = wd.detailsId "
                . "join v_fullmember mb "
                . "on mb.memberId = whis.memberId and mb.employeeTypeId = wc.valuex and wc.fieldMap = 'employeeTypeId' "
                . "where whis.dateCreated between :dateStart and :dateEnd "
                . "and whis.memberId = :memberId ";
        
        $sql2 = "select sum(whis.amount) as payment,wd.quantity-sum(whis.amount) as balance "
                . "from welfarehistory whis "
                . "join welfaredetails wd "
                . "on wd.detailsId = whis.detailsId "
                . "join welfare wel "
                . "on wel.welfareId = whis.welfareId and wel.code = 'medical001' "
                . "join welfareconditions wc "
                . "on wc.detailsId = wd.detailsId "
                . "join v_fullmember mb "
                . "on mb.memberId = whis.memberId and mb.employeeTypeId = wc.valuex and wc.fieldMap = 'employeeTypeId' "
                . "where whis.dateCreated between :dateStart and :dateEnd "
                . "and whis.memberId = :memberId ";
        
        $sql3 = "select mb.fname,mb.lname,titles1 "
                . "from v_fullmember mb "
                . "where  mb.memberId = $memberId ";
        
        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd,
            "memberId" => $memberId
        );

        if ($searchName != "") {
            $search = new MedicalFeeService();
            $view->lists = $search->search($searchName);
        } else {
            $budget = $this->datacontext->pdoQuery($sql1, $param);
            $budget2 = $this->datacontext->pdoQuery($sql2, $param);
            $member = $this->datacontext->pdoQuery($sql3);
            foreach ($budget as $key2 => $value2) {

                if ($budget[$key2]['dateCreated']!="") {

                    $dateTime = explode(" ", $value2['dateCreated']);
                    $date = $dateTime[0];
                    $date = explode("-", $date);
                    $date = $date[2] . "-" . $date[1] . "-" . intval($date[0] + 543);
                    $budget[$key2]['dateCreated'] = $date;

                    
                }
                if ($budget[$key2]['dateUpdated']!="") {
                    
                    $dateTime2 = explode(" ", $value2['dateUpdated']);
                    $date2 = $dateTime2[0];
                    $date2 = explode("-", $date2);
                    $date2 = $date2[2] . "-" . $date2[1] . "-" . intval($date2[0] + 543);
                    $budget[$key2]['dateUpdated'] = $date2;
                }
            }
            
//            print_r($budget);


            $view->lists = $budget;
            $view->sum = $budget2;
            $view->mem = $member;//กรณีที่ไม่ได้ search
        }
        return $view;
    }

    public function medicalFeeEdit($id) {

        $view = new CJView("medicalfee/edit", CJViewType::HTML_VIEW_ENGINE);

        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->setCode("medical001");
        $query = $this->datacontext->getObject($welfare)[0];

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $query->welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];

        $dateStart = $dateBudget["startDate"];
        $dateEnd = $dateBudget["endDate"];

        $sql1 = "select mb.fname,mb.lname,whis.welfareId,wc.conditionsId,whis.memberId,wd.quantity,mb.idCard,mb.department1,mb.faculty1,"
                . "sum(whis.amount) as payment,wd.quantity-sum(whis.amount) as balance,whis.remark,whis.dateCreated,whis.dateUpdated,whis.historyId, "
                . "IFNULL(mb.academic1,mb.titleName1) title "
                . "from welfarehistory whis "
                . "join welfaredetails wd "
                . "on wd.detailsId = whis.detailsId "
                . "join welfare wel "
                . "on wel.welfareId = whis.welfareId and wel.code = 'medical001' "
                . "join welfareconditions wc "
                . "on wc.detailsId = wd.detailsId "
                . "join v_fullmember mb "
                . "on mb.memberId = whis.memberId and mb.employeeTypeId = wc.valuex and wc.fieldMap = 'employeeTypeId' "
                . "where whis.dateCreated between :dateStart and :dateEnd "
                . "and whis.historyId = :id ";


        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd,
            "id" => $id
        );
        $budget = $this->datacontext->pdoQuery($sql1, $param)[0];
        $view->data = $budget;

        return $view;
    }

    public function medicalFeeShow($memberId) {
        $view = new CJView("user/show", CJViewType::HTML_VIEW_ENGINE);

        $searchName = $this->getRequest()->searchName;
        $welfare = new \apps\welfare\entity\Welfare();
        $welfare->setCode("medical001");
        $query = $this->datacontext->getObject($welfare)[0];

        $date = new \DateTime('now');
        $sql = "call prc_date_budget(:welfareId,:date)";
        $param = array(
            "welfareId" => $query->welfareId,
            "date" => $date->format('Y-m-d')
        );
        $dateBudget = $this->datacontext->pdoQuery($sql, $param)[0];

        $dateStart = $dateBudget["startDate"];
        $dateEnd = $dateBudget["endDate"];

        $sql = "select sum(whis.amount) as payment,wd.quantity-sum(whis.amount) as balance "
                . "from welfarehistory whis "
                . "join welfaredetails wd "
                . "on wd.detailsId = whis.detailsId "
                . "join welfare wel "
                . "on wel.welfareId = whis.welfareId and wel.code = 'medical001' "
                . "join welfareconditions wc "
                . "on wc.detailsId = wd.detailsId "
                . "join v_member mb "
                . "on mb.memberId = whis.memberId and mb.employeeTypeId = wc.valuex and wc.fieldMap = 'employeeTypeId' "
                . "Left JOIN taxonomy title "
                . "on mb.titleNameId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mb.academicId = academic.id "
                . "where whis.dateCreated between :dateStart and :dateEnd and whis.memberId = :memberId "
                . "group by whis.memberId ";

        $sql1 = "select mb.fname,mb.lname,whis.welfareId,wc.conditionsId,whis.memberId,wd.quantity, "
                . "whis.amount,whis.historyId,whis.dateCreated,whis.dateUpdated,whis.remark, "
                . "IFNULL(academic.value1,title.value1) title "
                . "from welfarehistory whis "
                . "join welfaredetails wd "
                . "on wd.detailsId = whis.detailsId "
                . "join welfare wel "
                . "on wel.welfareId = whis.welfareId and wel.code = 'medical001' "
                . "join welfareconditions wc "
                . "on wc.detailsId = wd.detailsId "
                . "join v_member mb "
                . "on mb.memberId = whis.memberId and mb.employeeTypeId = wc.valuex and wc.fieldMap = 'employeeTypeId' "
                . "Left JOIN taxonomy title "
                . "on mb.titleNameId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mb.academicId = academic.id "
                . "where whis.dateCreated between :dateStart and :dateEnd "
                . "and whis.memberId = :memberId ";

        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd,
            "memberId" => $memberId
        );

        if ($searchName != "") {
            $search = new MedicalFeeService();
            $view->lists = $search->search($searchName);
        } else {
            $budget = $this->datacontext->pdoQuery($sql1, $param);
            $total = $this->datacontext->pdoQuery($sql, $param);
//            print_r($total);
//            print_r($budget);
//            exit();
//            print_r($budget);
//            foreach ($budget as $key => $value) {
//                foreach($value as $key2 => $value2){
//                    if($key2=="dateCreated")
//                }
//            }
            $view->totalbudget = $total;
            $view->lists = $budget; //กรณีที่ไม่ได้ search
        }
        return $view;
    }

}
