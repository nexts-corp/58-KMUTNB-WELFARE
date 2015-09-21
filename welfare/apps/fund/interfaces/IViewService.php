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
      *@param string policyId
     * @return html view
     * @description view แก้ไข
     */
    public function policyAdminEdit($policyId);
}
