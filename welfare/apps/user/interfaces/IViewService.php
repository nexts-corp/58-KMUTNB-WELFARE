<?php

namespace apps\user\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {

    /**
     * @name memberLists
     * @uri /member/lists
     * @return html view
     * @description รายการผู้ใช้งาน
     */
    public function memberLists();

    /**
     * @name memberAdd
     * @uri /member/add
     * @return html view
     * @description view เพิ่มผู้ใช้งาน   
     */
    public function memberAdd();

    /**
     * @name memberEdit
     * @uri /member/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขผู้ใช้งาน   
     */
    public function memberEdit($id);
    
    
    
   
}
