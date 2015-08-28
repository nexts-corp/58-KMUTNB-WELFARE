<?php
namespace apps\welfare\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\welfare\interfaces\IViewService;

use apps\common\entity\Welfare;
use apps\common\entity\Register;
use apps\common\entity\WelfareRights;
use apps\common\entity\WelfareSub;
use apps\common\entity\WelfareConditions;
use apps\common\entity\PositionsType;

class ViewService extends CServiceBase implements IViewService{
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }
    
    public function viewAddSubwelfare($welfareId) {
        $view = new CJView("welfare/addSub", CJViewType::HTML_VIEW_ENGINE);
        $view->welfareId = $welfareId;
        return $view; 
    }

    public function viewWelfareSubList($welfareId) {
        $view = new CJView("welfare/sublistswel", CJViewType::HTML_VIEW_ENGINE);
        $filter = new WelfareSub();
        $filter->setWelfareId($welfareId);
        $welfare_sub = $this->datacontext->getObject($filter);
        $view->welfareId = $welfareId;
        $view->welfare = $welfare_sub;
        return $view;
    }

    public function viewconditions($welfareSubId) {
        $view = new CJView("welfare/conditions", CJViewType::HTML_VIEW_ENGINE);
        $position = new PositionsType();
        $getposition = $this->datacontext->getObject($position);
        
        $filter = new WelfareConditions();
        $filter->setWelfareSubId($welfareSubId);
        $welfare = $this->datacontext->getObject($filter);
        
        $path = '\\apps\\common\\entity\\';
        
        $sql = "SELECT welc.welfareConditionsId,welc.welfareSubId,welc.positionsTypeId,welc.dateStartWorking, "
                . "welc.dateEndWork,welc.ageWorkLess,welc.ageWorkMore,welc.ageWorkAs,welc.ageWorkSince,welc.ageWorkTo"
                . ",welc.ageLess,welc.ageMore,welc.ageAs,welc.ageSince,welc.ageTo,welc.statusVoluntary,welc.statusRetired"
                . ",pit.positionsTypeId,pit.positionsTypeNameTh,pit.positionsTypeNameEn"
                . " FROM ".$path."WelfareConditions welc LEFT JOIN ".$path."PositionsType pit with "
                . "welc.positionsTypeId = pit.positionsTypeId "
                . "where welc.welfareSubId = $welfareSubId";
        
        $welfare_edit_id = $this->datacontext->getObject($sql);
        //print_r($sql);
       // print_r($welfare_edit_id[0]->dateStartWorking->DateTime);
//        $date = $welfare_edit_id[0]->dateStartWorking;
//        $result = $date->format('Y-m-d H:i:s');
//        print_r($result);
//        print_r($welfare_edit_id[0]['dateStartWorking']->format('d-m-Y'));
            
        if ($welfare_edit_id == null) {
            $view->welfare = new WelfareConditions();
            $view->welcheckbox = new WelfareConditions();
            
            $view->welfareSubId = $welfareSubId;
            $view->position = $getposition;
            
            return $view;
        } else {
            $datestart = $welfare_edit_id[0]['dateStartWorking']->format('d-m-Y');
            $dateend = $welfare_edit_id[0]['dateEndWork']->format('d-m-Y');
            $view->welfare = $welfare_edit_id;
            $view->welcheckbox = $welfare;  
            $view->welfareSubId = $welfareSubId;
            $view->position = $getposition;
            $view->datestart = $datestart;
            $view->dateend = $dateend;
            //print_r($view);
            return $view;
        }
    }

    public function viewedit($welfareId) {
        $view = new CJView("welfare/edit", CJViewType::HTML_VIEW_ENGINE);
        $filter = new Welfare();
        $filter->setWelfareId($welfareId);
        $welfare_edit_id = $this->datacontext->getObject($filter);
        $view->welfare = $welfare_edit_id;
        return $view;
    }

    public function update($data) {
        if ($this->datacontext->updateObject($data)) {
            $this->getResponse()->add("message", "บันทึกข้อมูลสำเร็จ");
            return true;
        } else {
            $this->getResponse()->add("message", $this->datacontext->getLastMessage());
            return false;
        }
    }

    public function welfareAdd() {
        $view = new CJView("welfare/add", CJViewType::HTML_VIEW_ENGINE);

//        $listfaculty = new Faculty;
//        $listfac = $this->datacontext->getObject($listfaculty);
//
//        $view->listfac = $listfac;
        return $view;
    }

    public function welfareList() {
        $view = new CJView("welfare/lists", CJViewType::HTML_VIEW_ENGINE);
        $listWelfare = new Welfare();
        
        $listWel = $this->datacontext->getObject($listWelfare);
        print_r($listWel);
        if ($listWel!=null){
        $datestart = $listWel[0]->dateStart->format('d-m-Y');
        $dateEnd = $listWel[0]->dateEnd->format('d-m-Y');
        
        $view->wdateStart =  $datestart;
        $view->wdateEnd = $dateEnd;
        $view->welfare = $listWel;
        return $view;
        }else{
            $view->welfare = $listWel;
            return $view;
        }
        
        
    }

    public function welfareedit($welfareId) {
        $view = new CJView("welfare/edit", CJViewType::HTML_VIEW_ENGINE);
        $filter = new Welfare();
        $filter->setWelfareId($welfareId);
        $welfare_edit_id = $this->datacontext->getObject($filter);
        $view->welfare = $welfare_edit_id;
        return $view;
    }

    public function welfareeditsub($welfareSubId) {
        
        $view = new CJView("welfare/editSub", CJViewType::HTML_VIEW_ENGINE);
        $filter = new WelfareSub();
        $filter->setWelfareSubId($welfareSubId);
        $welfaresub_edit = $this->datacontext->getObject($filter);
        //print_r($welfaresub_edit);
        $view->welfare = $welfaresub_edit;
        return $view;
    }

    public function welfareCutList() {
        $view = new CJView("welfareCut/list", CJViewType::HTML_VIEW_ENGINE);
        $listWelfare = new Welfare();

        $listWel = $this->datacontext->getObject($listWelfare);
        $view->welfareClaims = $listWel;
        return $view;
    }

    public function welfareclaimslist() {
        $view = new CJView("welfareClaims/list", CJViewType::HTML_VIEW_ENGINE);
        $listWelfare = new Welfare();

        $listWel = $this->datacontext->getObject($listWelfare);
        $view->welfareClaims = $listWel;
        return $view;
    }

    public function welfareclaimsAdd() {
        $view = new CJView("welfareClaims/add", CJViewType::HTML_VIEW_ENGINE);
       
        return $view;
    }

    public function welfareclaimssendList() {
        $view = new CJView("welfareClaims/send", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function welfareclaimswaitList() {
        $view = new CJView("welfareClaims/wait", CJViewType::HTML_VIEW_ENGINE);

        return $view;
    }

    public function welfareclaimsshow() {
        
        $sql = "SELECT re.registerId,concat(ti.titleNameTh,' ',re.registerNameTh,' ',re.registerLastNameTh) as fullname ,de.departmentNameTh,fa.facultyNameTh
FROM register re
left join titlename ti on re.titleNameId = ti.titleNameId
left join department de on re.departmentId = de.departmentId
left join faculty fa on re.facultyId = fa.facultyId";
        $info = $this->datacontext->pdoQuery($sql);
        if($info){
            return $info;
        }
        return NULL;
    }

    public function welfareclaimslistWelfare($registerId) {
        $view = new CJView("welfareclaims/add", CJViewType::HTML_VIEW_ENGINE);
        $list = new Register();
        $list->setRegisterId($registerId);
        $listde = $this->datacontext->getObject($list);
        $view->registerId = $registerId;

        return $view;
    }

    public function welfareclaimsshowAdd($registerId) {
        $user = new Register();
        $user->setRegisterId($registerId);
        $data = $this->datacontext->getObject($user);


        $sql = "SELECT *,

  CASE WHEN

  case0
  +
  if(tb.ageLess != 0 and case1 = 0,0,1)
  +
  if(tb.ageMore != 0 and case2 = 0,0,1)
  +
  if(tb.ageAs != 0 and case3 = 0,0,1)
  +
  if(tb.ageSince != 0 and case4 = 0,0,1)
  +
  if(tb.ageWorkLess != 0 and case5 = 0,0,1)
  +
  if(tb.ageWorkMore != 0 and case6 = 0,0,1)
  +
  if(tb.ageWorkAs != 0 and case7 = 0,0,1)
  +
  if(tb.ageWorkSince != 0 and case8 = 0,0,1)


  = 9 Then 1 ELSE 0 END as isTarget


 from ( select
       we.welfareId,ws.welfareSubId,we.welfareName,ws.amount,IFNULL(wr.statusId, 0) as statusId,

       wc.ageLess as  ageLess,wc.ageMore as ageMore,wc.ageAs as  ageAs,wc.ageSince as  ageSince,wc.ageTo as ageTo,

       wc.ageWorkLess as  ageWorkLess,wc.ageWorkMore as ageWorkMore,wc.ageWorkAs as  ageWorkAs,wc.ageWorkSince as ageWorkSince,
       wc.ageWorkTo as  ageWorkTo,

       CASE WHEN  curdate() >= we.welfareStart  AND we.welfareEnd <= curdate() THEN 1 ELSE 0 END as case0,
       CASE WHEN wc.ageLess != 0   AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) < wc.ageLess THEN 1 ELSE 0 END as case1,
       CASE WHEN wc.ageMore != 0   AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) > wc.ageMore THEN 1 ELSE 0 END as case2,
       CASE WHEN wc.ageAs != 0     AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) = wc.ageAs THEN 1 ELSE 0 END as case3,
       CASE WHEN wc.ageSince != 0  AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) >= wc.ageSince and
       		 wc.ageTo != 0 AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) <= wc.ageTo THEN 1 ELSE 0 END as case4,


       CASE WHEN wc.ageWorkLess != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) < wc.ageWorkLess THEN 1 ELSE 0 END as case5,
       CASE WHEN wc.ageWorkMore != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) > wc.ageWorkMore THEN 1 ELSE 0 END as case6,
       CASE WHEN wc.ageWorkAs != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) = wc.ageWorkAs THEN 1 ELSE 0 END as case7,
       CASE WHEN wc.ageWorkSince != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) >= wc.ageWorkSince and
                 wc.ageWorkTo != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) <= wc.ageWorkTo THEN 1 ELSE 0 END as case8,

       CASE WHEN IFNULL(wr.welfareId, 0) = we.welfareId THEN 1 ELSE 0 END as isUsed

FROM welfare we
left join welfaresub ws on we.welfareId = ws.welfareId
left join welfareconditions wc on ws.welfareSubId = wc.welfareSubId
left join welfarerights wr on we.welfareId = wr.welfareId

join register re where re.registerId = ".$registerId." and wc.positionsTypeId = ".$data[0]->positionsWorkId."
order by ws.amount desc ) tb
";

        //join register re where re.registerId = ".$registerId." and wc.positionsTypeId = ".$data[0]->positionsWorkId."
        //order by ws.amount desc ) tb


        $info = $this->datacontext->pdoQuery($sql);
        if($info){
            return $info;
        }
        return NULL;

    }

    public function welfareclaimsshowApprove($registerId) {
        
        $sql = "SELECT wr.welfareRightsId,wr.welfareId,wr.registerId,wr.amount,wf.welfareName,wr.statusId FROM welfarerights wr
left join welfare wf on wr.welfareId = wf.welfareId WHERE wr.registerId = ".$registerId;

        $info = $this->datacontext->pdoQuery($sql);
        if($info){
            return $info;
        }
        return NULL;
    }

    public function approve($welfareRightsId) {

        $sql = "UPDATE welfarerights SET statusId = 2 WHERE welfareRightsId = ".$welfareRightsId;

        $info = $this->datacontext->pdoQuery($sql);
        if($info){
            return $info;
        }
        return NULL;

    }

//put your code here
}
