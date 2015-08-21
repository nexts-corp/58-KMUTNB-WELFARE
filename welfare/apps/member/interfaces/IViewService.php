<?php
namespace apps\member\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 * 
 */

interface IViewService {
    /**
     * @name familyLists
     * @uri /family/lists
     * @param integer id Description
     * @return html view xxx
     * @description รายการผู้มีความสัมพันธ์
     */
    public function familyLists($id);
    
     
    
    /**
     * @name familyAdd
     * @uri /family/add
     * @param string registerId Description
     * @return html viewAdd Description
     * @description view เพิ่มข้อมูลผู้มีความสัมพันธ์   
     */
    public function familyAdd($registerId);

    /**
     * @name familyEdit
     * @uri /family/edit
     * @param integer id Description
     * @return html viewEdit Description
     * @description view แก้ไขข้อมูลผู้มีความสัมพันธ์   
     */
    public function familyEdit($id);
    
    /**
     * @name memberLists
     * @uri /member/lists
     * @return html view xxx
     * @description รายการข้อมูลสมาชิก
     */
    public function memberLists();
    
    /**
     * @name memberAdd
     * @uri /member/add
     * @return html memberAdd Description
     * @description view เพิ่มข้อมูลสมาชิก   
     */
    public function memberAdd();
    
    /**
     * @name memberEdit
     * @uri /member/edit
     * @param integer id Description
     * @return html viewEdit Description
     * @description view แก้ไขข้อมูลสมาชิก   
     */
    public function memberEdit($id);



    /**
     * @name list
     * @uri /welfare/info
     * @return html view
     * @description รายการประเภทผู้ใช้งาน
     */
    public function viewInfo();

    /**
     * @name list
     * @uri /welfare/wait
     * @return html view
     * @description รายการประเภทผู้ใช้งาน
     */
    public function viewWait();



    /**
     * @name showApprove
     * @uri /show/approve
     * @param Int registerId Description
     * @return html showApprove Description
     * @description แสดงสวัสดิการแต่ละบุคคล
     */
    public function showApprove($registerId);


    /**
     * @name showAdd
     * @uri /list/add
     * @param Int registerId Description
     * @return html listWelfare Description
     * @description สมาชิกตรวจดูรายการสวัสดิการ
     */
    public function showAdd($registerId);

    /**
     * @name add
     * @uri /add
     * @param Int registerId Description
     * @param Int welfareId Description
     * @return html add Description
     * @description สมาชิกตรวจดูรายการสวัสดิการ
     */
    public function add($registerId,$welfareId);



}
