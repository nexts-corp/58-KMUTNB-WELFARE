<?php
namespace apps\member\service;

use apps\common\entity\Register;
use apps\common\entity\WelfareRights;
use apps\common\entity\WelfareSub;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\member\interfaces\IViewService;

use apps\common\entity\Family;

class ViewService extends CServiceBase implements IViewService{
    
    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext("default");
    }
    
    
    public function familyAdd($registerId) {
         $view = new CJView("family/management/add", CJViewType::HTML_VIEW_ENGINE);
        $view->academicPositions = $this->datacontext->getObject(new \apps\common\entity\AcademicPositions());
        $view->rank = $this->datacontext->getObject(new \apps\common\entity\Rank());
        $view->titleName = $this->datacontext->getObject(new \apps\common\entity\TitleName());
        
        $view->register = $registerId;
        
        return $view;
    }

    public function familyEdit($id) {
        $view = new CJView("family/management/edit", CJViewType::HTML_VIEW_ENGINE);
        $view->rank = $this->datacontext->getObject(new \apps\common\entity\Rank());
        $view->titleName = $this->datacontext->getObject(new \apps\common\entity\TitleName());
        
        $filter = new Family();
        $filter->setFamilyId($id);
        $dao_family = $this->datacontext->getObject($filter);
        $view->data = $dao_family;
        return $view;
    }

    public function familyLists($id) {
        $view = new CJView("family/management/lists", CJViewType::HTML_VIEW_ENGINE);
        $filter = new Family();
        $filter->setRegisterId($id);
        $dao_family = $this->datacontext->getObject($filter);
        $view->register = $id;
        $view->data = $dao_family;
        return $view;
    }

    public function memberAdd() {
        $view = new CJView("register/management/add", CJViewType::HTML_VIEW_ENGINE);
        $view->academicPositions = $this->datacontext->getObject(new \apps\common\entity\AcademicPositions());
        $view->rank = $this->datacontext->getObject(new \apps\common\entity\Rank());
        $view->titleName = $this->datacontext->getObject(new \apps\common\entity\TitleName());
        $view->positionsType = $this->datacontext->getObject(new \apps\common\entity\PositionsType());
        $view->positionsWork = $this->datacontext->getObject(new \apps\common\entity\PositionsWork());
        $view->faculty = $this->datacontext->getObject(new \apps\common\entity\Faculty());
        $view->department = $this->datacontext->getObject(new \apps\common\entity\Department());
        return $view;
    }

    public function memberEdit($id) {
        $view = new CJView("register/management/edit", CJViewType::HTML_VIEW_ENGINE);
        $view->academicPositions = $this->datacontext->getObject(new \apps\common\entity\AcademicPositions());
        $view->rank = $this->datacontext->getObject(new \apps\common\entity\Rank());
        $view->titleName = $this->datacontext->getObject(new \apps\common\entity\TitleName());
        $view->positionsType = $this->datacontext->getObject(new \apps\common\entity\PositionsType());
        $view->positionsWork = $this->datacontext->getObject(new \apps\common\entity\PositionsWork());
        $view->faculty = $this->datacontext->getObject(new \apps\common\entity\Faculty());
        $view->department = $this->datacontext->getObject(new \apps\common\entity\Department());
        
        $filter = new Register();
        $filter->setRegisterId($id);
        $dao_register = $this->datacontext->getObject($filter);
        $view->data = $dao_register;
        return $view;
    }

    public function memberLists() {
       $view = new CJView("member/management/lists", CJViewType::HTML_VIEW_ENGINE);
       $path = '\\apps\\common\\entity\\';
       $sql = "SELECT aca.academicPositionsNameTh,ra.rankNameTh,tit.titleNameTh,reg.registerId, reg.registerNameTh,"
               . "reg.registerLastNameTh,de.departmentNameTh, reg.registerIdCard, fac.facultyNameTh, de.departmentNameTh "
                . "FROM ".$path."Register reg "
                . "LEFT JOIN ".$path."AcademicPositions aca with "
                . "reg.academicPositionsId = aca.academicPositionsId "
                . "LEFT JOIN ".$path."Rank ra with reg.rankId = ra.rankId "
                . "LEFT JOIN ".$path."Titlename tit with tit.titleNameId = reg.titleNameId "
                . "LEFT JOIN  ".$path."department de with de.departmentId = reg.departmentId "
               . "LEFT JOIN  ".$path."faculty fac with fac.facultyId = de.facultyId "
                . "ORDER BY reg.registerId DESC";
        //print_r($sql);
        $listreg = $this->datacontext->getObject($sql);
        $view->list = $listreg;
        return $view;
    }






    public function viewInfo() {

        $view = new CJView("welfare/info/lists", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }


    public function viewWait() {

        $view = new CJView("welfare/info/wait", CJViewType::HTML_VIEW_ENGINE);
        return $view;

    }


    public function showApprove($registerId) {

        $sql = "SELECT wr.welfareRightsId,wr.welfareId,wr.registerId,wr.amount,wf.welfareName,wr.statusId,wf.welfareStart,wf.welfareEnd FROM welfarerights wr
        left join welfare wf on wr.welfareId = wf.welfareId WHERE wr.registerId = ".$registerId;

        $info = $this->datacontext->pdoQuery($sql);
        if($info){
            return $info;
        }
        return NULL;
    }


    public function showAdd($registerId) {
        $user = new Register();
        $user->setRegisterId($registerId);
        $data = $this->datacontext->getObject($user);

        $position = $data[0]->positionsWorkId;
        if($position == null && $position == ''){
            $position = 0;
        }




        $sql = "
        SELECT we.welfareId,ws.welfareSubId,we.welfareName,ws.amount,we.welfareStart,we.welfareEnd,
        IFNULL((select wrr.statusId from  welfarerights wrr where wrr.registerId = " . $registerId . " and wrr.welfareId = we.welfareId order by wrr.welfareRightsId desc limit 1  ),0) as statusId,
        (select registerDateofBirth from register ree where ree.registerId = " . $registerId . " ) as birth,
(select registerDateAdded from register ree where ree.registerId = " . $registerId . " ) as dateIn,
( SELECT CASE WHEN curdate() >= wee.welfareStart  AND curdate() <= wee.welfareEnd THEN 1 ELSE 0 END  from welfare wee  where wee.welfareId = we.welfareId) as case0,

( SELECT CASE WHEN wc.ageLess != 0   AND timestampdiff( YEAR,birth,curdate() ) < wc.ageLess THEN 1 ELSE 0 END  from welfare wee where wee.welfareId = we.welfareId )  as case1,

( SELECT CASE WHEN wc.ageMore != 0   AND timestampdiff( YEAR,birth,curdate() ) > wc.ageMore THEN 1 ELSE 0 END  from welfare wee  where wee.welfareId = we.welfareId )  as case2,

( SELECT CASE WHEN wc.ageAs != 0     AND timestampdiff( YEAR,birth,curdate() ) = wc.ageAs THEN 1 ELSE 0 END  from welfare wee  where wee.welfareId = we.welfareId)  as case3,

( SELECT CASE WHEN wc.ageSince != 0  AND timestampdiff( YEAR,birth,curdate() ) >= wc.ageSince and
       		 wc.ageTo != 0 AND timestampdiff( YEAR,birth,curdate() ) <= wc.ageTo THEN 1 ELSE 0 END  from welfare wee  where wee.welfareId = we.welfareId)  as case4,


( SELECT CASE WHEN wc.ageWorkLess != 0 AND timestampdiff( YEAR,dateIn,curdate() ) < wc.ageWorkLess THEN 1 ELSE 0 END from welfare wee  where wee.welfareId = we.welfareId )  as case5,
( SELECT CASE WHEN wc.ageWorkMore != 0 AND timestampdiff( YEAR,dateIn,curdate() ) > wc.ageWorkMore THEN 1 ELSE 0 END from welfare wee  where wee.welfareId = we.welfareId )  as case6,
( SELECT CASE WHEN wc.ageWorkAs != 0 AND timestampdiff( YEAR,dateIn,curdate() ) = wc.ageWorkAs THEN 1 ELSE 0 END from welfare wee  where wee.welfareId = we.welfareId)   as case7,
( SELECT CASE WHEN wc.ageWorkSince != 0 AND timestampdiff( YEAR,dateIn,curdate() ) >= wc.ageWorkSince and
                 wc.ageWorkTo != 0 AND timestampdiff( YEAR,dateIn,curdate() ) <= wc.ageWorkTo THEN 1 ELSE 0 END from welfare wee  where wee.welfareId = we.welfareId  )   as case8,

( SELECT CASE WHEN IFNULL(wr.welfareId, 0) = wee.welfareId THEN 1 ELSE 0 END from welfare wee  where wee.welfareId = we.welfareId )   as isUsed,
( select CASE WHEN
  case0
  +
  if(wc.ageLess != 0 and case1 = 0,0,1)
  +
  if(wc.ageMore != 0 and case2 = 0,0,1)
  +
  if(wc.ageAs != 0 and case3 = 0,0,1)
  +
  if(wc.ageSince != 0 and case4 = 0,0,1)
  +
  if(wc.ageWorkLess != 0 and case5 = 0,0,1)
  +
  if(wc.ageWorkMore != 0 and case6 = 0,0,1)
  +
  if(wc.ageWorkAs != 0 and case7 = 0,0,1)
  +
  if(wc.ageWorkSince != 0 and case8 = 0,0,1)

  = 9 Then 1 ELSE 0 END
) as isTarget


FROM welfare we
left join welfaresub ws on we.welfareId = ws.welfareId
left join welfareconditions wc on ws.welfareSubId = wc.welfareSubId
left join welfarerights wr on we.welfareId = wr.welfareId
left join register re on wr.registerId = re.registerId









        ";
//        $sql = "SELECT *,
//
//  CASE WHEN
//
//  case0
//  +
//  if(tb.ageLess != 0 and case1 = 0,0,1)
//  +
//  if(tb.ageMore != 0 and case2 = 0,0,1)
//  +
//  if(tb.ageAs != 0 and case3 = 0,0,1)
//  +
//  if(tb.ageSince != 0 and case4 = 0,0,1)
//  +
//  if(tb.ageWorkLess != 0 and case5 = 0,0,1)
//  +
//  if(tb.ageWorkMore != 0 and case6 = 0,0,1)
//  +
//  if(tb.ageWorkAs != 0 and case7 = 0,0,1)
//  +
//  if(tb.ageWorkSince != 0 and case8 = 0,0,1)
//
//
//  = 9 Then 1 ELSE 0 END as isTarget
//
//
// from ( select
//       we.welfareId,ws.welfareSubId,we.welfareName,ws.amount,IFNULL((select wrr.statusId from  welfarerights wrr where wrr.registerId = " . $registerId . " order by wrr.welfareRightsId desc limit 1  ),0) as statusId,
//
//       wc.ageLess as  ageLess,wc.ageMore as ageMore,wc.ageAs as  ageAs,wc.ageSince as  ageSince,wc.ageTo as ageTo,
//
//       wc.ageWorkLess as  ageWorkLess,wc.ageWorkMore as ageWorkMore,wc.ageWorkAs as  ageWorkAs,wc.ageWorkSince as ageWorkSince,
//       wc.ageWorkTo as  ageWorkTo,
//
//       CASE WHEN  curdate() >= we.welfareStart  AND we.welfareEnd <= curdate() THEN 1 ELSE 0 END as case0,
//       CASE WHEN wc.ageLess != 0   AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) < wc.ageLess THEN 1 ELSE 0 END as case1,
//       CASE WHEN wc.ageMore != 0   AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) > wc.ageMore THEN 1 ELSE 0 END as case2,
//       CASE WHEN wc.ageAs != 0     AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) = wc.ageAs THEN 1 ELSE 0 END as case3,
//       CASE WHEN wc.ageSince != 0  AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) >= wc.ageSince and
//       		 wc.ageTo != 0 AND timestampdiff( YEAR,re.registerDateofBirth,curdate() ) <= wc.ageTo THEN 1 ELSE 0 END as case4,
//
//
//       CASE WHEN wc.ageWorkLess != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) < wc.ageWorkLess THEN 1 ELSE 0 END as case5,
//       CASE WHEN wc.ageWorkMore != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) > wc.ageWorkMore THEN 1 ELSE 0 END as case6,
//       CASE WHEN wc.ageWorkAs != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) = wc.ageWorkAs THEN 1 ELSE 0 END as case7,
//       CASE WHEN wc.ageWorkSince != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) >= wc.ageWorkSince and
//                 wc.ageWorkTo != 0 AND timestampdiff( YEAR,re.registerDateAdded,curdate() ) <= wc.ageWorkTo THEN 1 ELSE 0 END as case8,
//
//       CASE WHEN IFNULL(wr.welfareId, 0) = we.welfareId THEN 1 ELSE 0 END as isUsed
//
//FROM welfare we
//left join welfaresub ws on we.welfareId = ws.welfareId
//left join welfareconditions wc on ws.welfareSubId = wc.welfareSubId
//left join welfarerights wr on we.welfareId = wr.welfareId
//
//join register re where re.registerId = " . $registerId . " and wc.positionsTypeId = " .$position. "
//order by ws.amount desc ) tb
//";

        //join register re where re.registerId = ".$registerId." and wc.positionsTypeId = ".$data[0]->positionsWorkId."
        //order by ws.amount desc ) tb


        $info = $this->datacontext->pdoQuery($sql);
        if ($info) {
            return $info;
        }
        return NULL;
    }

    public function add($registerId, $welfareId) {

        $wel = new WelfareSub();
        $wel->setWelfareSubId($welfareId);
        $data = $this->datacontext->getObject($wel);

//        $dt = new \DateTime();
//        $dt->format('Y-m-d H:i:s');


        $wel_right = new WelfareRights();

        $wel_right->setWelfareId($data[0]->welfareId);
        $wel_right->setRegisterId($registerId);
        $wel_right->setAmount($data[0]->amount);
        $wel_right->setDateStartWelfare(new \DateTime());
        $wel_right->setStatusId('1');
        //return new \DateTime();
        return $this->datacontext->saveObject($wel_right);

    }

//put your code here
}
