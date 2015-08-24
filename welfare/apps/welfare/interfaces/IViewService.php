<?php
namespace apps\welfare\interfaces;
/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 * 
 */
interface IViewService {
    /**
     * @name viewList
     * @uri /welfare/list
     * @return html viewList xxx
     * @description หน้าแสดงรายการจัดการสมาชิก
     */
    public function welfareList();
    
    /**
     * @name viewWelfareSubList
     * @uri /welfare/list/sub
     * @param String welfareId Description
     * @return html viewList xxx
     * @description หน้าแสดงรายการจัดการสมาชิก
     */
    public function viewWelfareSubList($welfareId);
    
    /**
     * @name viewAddwelfare
     * @uri /welfare/add
     * @return html viewAddwelfare Description
     * @description view Add welfare 
     */
    public function welfareAdd();
    
    /**
     * @name viewAddSubwelfare
     * @uri /welfare/add/sub
     * @param String welfareId Description
     * @return html viewAddSubwelfare Description
     * @description view Add sub welfare 
     */
    public function viewAddSubwelfare($welfareId);
    
    /**
     * @name viewconditions
     * @uri /welfare/conditions
     * @param String welfareSubId Description
     * @return html viewconditions Description
     * @description view conditions 
     */
    public function viewconditions($welfareSubId);
    
    
    /**
     * @name viewedit
     * @uri /welfare/edit
     * @param String welfareId Description
     * @return html viewedit Description
     * @description view list new
     */
    public function welfareedit($welfareId);
    
    /**
     * @name vieweditsub
     * @uri /welfare/editsub
     * @param String welfareSubId Description
     * @return html vieweditsub Description
     * @description view list new
     */
    public function welfareeditsub($welfareSubId);
    
    /**
     * @name viewList
     * @uri /welfareCut/list
     * @return html viewList xxx
     * @description หน้าแสดงรายการจัดการสมาชิก
     */
    public function welfareCutList();

    /**
     * @name viewList
     * @uri /welfareclaims/list
     * @return html viewList xxx
     * @description หน้าแสดงรายการจัดการสมาชิก
     */
    public function welfareclaimslist();
    
    /**
     * @name welfareclaimsAdd
     * @uri /welfareclaims/add
     * @return html viewAddclaims Description
     * @description view Add claims
     */
    public function welfareclaimsAdd();
    
    /**
     * @name sendList
     * @uri /welfareclaims/send
     * @return html send xxx
     * @description หน้าแสดงรายการจัดการสมาชิก
     */
    public function welfareclaimssendList();

    /**
     * @name waitList
     * @uri /welfareclaims/wait
     * @return html wait xxx
     * @description หน้าแสดงรายการจัดการสมาชิก
     */
    public function welfareclaimswaitList();
    
    /**
     * @name show
     * @uri /welfareclaims/show
     * @return html show Description
     * @description view show claims
     */
    public function welfareclaimsshow();
    
    
    /**
     * @name listWelfare
     * @uri /welfareclaims/list/welfare
     * @param Int registerId Description
     * @return html listWelfare Description
     * @description แสดงสวัสดิการแต่ละบุคคล
     */
    public function welfareclaimslistWelfare($registerId);
    
    /**
     * @name showAdd
     * @uri /welfareclaims/list/add
     * @param Int registerId Description
     * @return html listWelfare Description
     * @description แสดงสวัสดิการแต่ละบุคคล
     */
    public function welfareclaimsshowAdd($registerId);
    
    /**
     * @name welfareclaimsshowApprove
     * @uri /welfareclaims/show/approve
     * @param Int registerId Description
     * @return html showApprove Description
     * @description แสดงสวัสดิการแต่ละบุคคล
     */
    public function welfareclaimsshowApprove($registerId);
}
