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

        $sql1 = "select mem.fname,mem.lname,wh.welfareId,wc.conditionsId,wh.remark,wh.memberId,wc.quantity,"
                . "sum(wh.amount) as payment,wc.quantity-sum(wh.amount) as balance, "
                . "IFNULL(academic.value1,title.value1) title "
                . "from welfarehistory wh "
                . "inner join welfare wel "
                . "on wel.welfareId = wh.welfareId and wel.code = 'medical001' "
                . "inner join welfareconditions wc "
                . "on wc.conditionsId = wh.conditionsId "
                . "inner join member mem "
                . "on mem.memberId = wh.memberId and wc.employeeTypeId = mem.employeeTypeId "
                . "Left JOIN taxonomy title "
                . "on mem.titleId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mem.academicId = academic.id "
                . "where wh.dateCreated between :dateStart and :dateEnd "
                . "group by wh.memberId ";

        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd
        );


        if ($searchName != "") {
            $search = new MedicalFeeService();
            $view->lists = $search->search($searchName);
        } else {
            $budget = $this->datacontext->pdoQuery($sql1, $param);
            $view->lists = $budget; //กรณีที่ไม่ได้ search
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

        $sql1 = "select mem.fname,mem.lname,wh.welfareId,wc.conditionsId,wh.remark,wh.memberId,wc.quantity,"
                . "wh.amount,wh.historyId,wh.dateCreated,wh.dateUpdated, "
//                . "sum(wh.amount) as payment,wc.quantity-sum(wh.amount) as balance, "
                . "IFNULL(academic.value1,title.value1) title "
                . "from welfarehistory wh "
                . "inner join welfare wel "
                . "on wel.welfareId = wh.welfareId and wel.code = 'medical001' "
                . "inner join welfareconditions wc "
                . "on wc.conditionsId = wh.conditionsId "
                . "inner join member mem "
                . "on mem.memberId = wh.memberId and wc.employeeTypeId = mem.employeeTypeId "
                . "Left JOIN taxonomy title "
                . "on mem.titleId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mem.academicId = academic.id "
                . "where wh.dateCreated between :dateStart and :dateEnd "
                . "and wh.memberId = :memberId ";

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
//            print_r($budget);
//            foreach ($budget as $key => $value) {
//                foreach($value as $key2 => $value2){
//                    if($key2=="dateCreated")
//                }
//            }

            $view->lists = $budget; //กรณีที่ไม่ได้ search
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

        $sql1 = "select mem.fname,mem.lname,wh.welfareId,wc.conditionsId,wh.memberId,wc.quantity,"
                . "sum(wh.amount) as payment,wc.quantity-sum(wh.amount) as balance,mem.idCard,wh.amount,wh.remark,wh.historyId, "
                . "IFNULL(academic.value1,title.value1) title "
                . "from welfarehistory wh "
                . "inner join welfare wel "
                . "on wel.welfareId = wh.welfareId and wel.code = 'medical001' "
                . "inner join welfareconditions wc "
                . "on wc.conditionsId = wh.conditionsId "
                . "inner join member mem "
                . "on mem.memberId = wh.memberId  and wc.employeeTypeId = mem.employeeTypeId "
                . "Left JOIN taxonomy title "
                . "on mem.titleId = title.id "
                . "Left JOIN taxonomy academic "
                . "on mem.academicId = academic.id "
                . "where wh.dateCreated between :dateStart and :dateEnd and wh.historyId = :id";

        $param = array(
            "dateStart" => $dateStart,
            "dateEnd" => $dateEnd,
            "id" => $id
        );
        $budget = $this->datacontext->pdoQuery($sql1, $param)[0];
        $view->data = $budget;

        return $view;
    }

}
