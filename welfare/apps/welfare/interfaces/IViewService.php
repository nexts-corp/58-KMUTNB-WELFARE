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
     * @param integer id Description
     * @return html welfareEdit Description
     * @description view แก้ไขข้อมูลสวัสดิการ
     */
    public function welfareEdit($id);
    
    /**
     * @name conditionList
     * @uri /condition/lists
     * @param integer id Description
     * @return html viewList 
     * @description จัดการเงื่อนไขสวัสดิการ
     */
    public function conditionLists($id);
    
    /**
     * @name conditionAdd
     * @uri /condition/add
     * @param integer id Description
     * @return html viewAddSubwelfare Description
     * @description view เพิ่มเงื่อนไขสวัสดิการ
     */
    public function conditionAdd($id);
    
    /**
     * @name conditionEdit
     * @uri /condition/edit
     * @param integer id Description
     * @return html viewconditions Description
     * @description view แก้ไขเงื่อนไขสวัสดิการ 
     */
    public function conditionEdit($id);

    
}
