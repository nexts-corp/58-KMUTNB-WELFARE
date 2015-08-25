<?php

namespace apps\user\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {

    /**
     * @name typeLists
     * @uri /type/lists
     * @return html view
     * @description รายการประเภทผู้ใช้งาน
     */
    public function typeLists();

    /**
     * @name typeAdd
     * @uri /type/add
     * @return html view
     * @description view เพิ่มประเภทผู้ใช้งาน   
     */
    public function typeAdd();

    /**
     * @name typeEdit
     * @uri /type/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขประเภทผู้ใช้งาน   
     */
    public function typeEdit($id);

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
