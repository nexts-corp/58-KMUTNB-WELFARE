<?php

namespace apps\fund\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {

    /**
     * @name policyAdminLists
     * @uri /policy/admin/lists
     * @return html view
     * @description รายการประเภทพนักงาน
     */
    public function policyAdminLists();

    /**
     * @name policyAdminAdd
     * @uri /policy/admin/add
     * @return html view
     * @description view เพิ่มประเภทพนักงาน
     */
    public function policyAdminAdd();

    /**
     * @name policyAdminEdit
     * @uri /policy/admin/edit
     * @param string policyId
     * @return html view
     * @description view แก้ไข
     */
    public function policyAdminEdit($policyId);

    /**
     * @name employeeAdminLists
     * @uri /employee/admin/lists
     * @return html view
     * @description รายการประเภทพนักงาน
     */
    public function employeeAdminLists();

    /**
     * @name employeeUserLists
     * @uri /employee/admin/user
     * @return html view
     * @description หน้าแสดงรายการกองทุนของ user
     */
    public function employeeUserLists();
    
     /**
     * @name extraAdminLists
     * @uri /extra/admin/lists
     * @return html view
     * @description หน้าแสดงกองทุนพนักงานข้าราชการ,ข้าราชการพิเศษฝั่งAdmin
     */
    public function extraAdminLists();
    
     /**
     * @name extraUserLists
     * @uri /extra/user/lists
     * @return html view
     * @description หน้าแสดงกองทุนพนักงานข้าราชการ,ข้าราชการพิเศษฝั่งUser
     */
    public function extraUserLists();
    
    /**
     * @name retireAdminLists
     * @uri /retire/admin/lists
     * @return html view
     * @description หน้าแสดงกองทุนพนักงานจ้างหลังเกษียณฝั่งAdmin
     */
    public function retireAdminLists();
    
     /**
     * @name retireUserLists
     * @uri /retire/user/lists
     * @return html view
     * @description หน้าแสดงกองทุนพนักงานจ้างหลังเกษียณฝั่งUser
     */
    public function retireUserLists();

}
