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
     * @uri /welfare/lists
     * @return html viewList xxx
     * @description จัดการรายการสวัสดิการ
     */
    public function welfareLists();
    
    /**
     * @name welfareAdd
     * @uri /welfare/add
     * @return html welfareAdd Description
     * @description view เพิ่มข้อมูลสวัสดิการ
     */
    public function welfareAdd();
    
    /**
     * @name viewedit
     * @uri /welfare/edit
     * @return html welfareEdit Description
     * @description view แก้ไขข้อมูลสวัสดิการ
     */
    public function welfareEdit();
    
    /**
     * @name conditionsList
     * @uri /conditions/lists
     * @return html viewList 
     * @description จัดการเงื่อนไขสวัสดิการ
     */
    public function conditionsLists();
    
    /**
     * @name conditionsAdd
     * @uri /conditions/add
     * @return html viewAddSubwelfare Description
     * @description view เพิ่มเงื่อนไขสวัสดิการ
     */
    public function conditionsAdd();
    
    /**
     * @name conditionsEdit
     * @uri /conditions/edit
     * @return html viewconditionss Description
     * @description view แก้ไขเงื่อนไขสวัสดิการ 
     */
    public function conditionsEdit();
    
    /**
     * @name viewPrivewsList
     * @uri /priviews/lists
     * @param apps\welfare\entity\Conditions data []
     * @return html previews
     * @description แสดงรายการผู้มีสิทธิได้รับสวัสดิการ
     */
    public function previewsUserLists($data);

    /**
     * @name preview
     * @uri /history/lists
     * @param apps\welfare\entity\History data []
     * @return string history
     * @description test
     */
    public function historyPreview($data);
    
    /**
     * @name add
     * @uri /history/add
     * @param apps\welfare\entity\History data []
     * @return string history
     * @description test
     */
    public function historyAdd($data);
    
    /**
     * @name add
     * @uri /history/edit
     * @return string history
     * @description test
     */
    public function historyEdit();
    
    /**
     * @name viewPrivewsList
     * @uri /byMember/lists
     * @return html previews
     * @description แสดงสวัสดิการรายบุคคล
     */
    public function byMemberLists();
    
    /**
     * @name viewMemberWelfarePrivewsList
     * @uri /byMemberWelfare/lists
     * @param apps\welfare\entity\Conditions data []
     * @return html previews
     * @description แสดงรายการสวัสดิการที่พึงจะได้รับ
     */
    public function byMemberWfLists($data);
    
    
}
