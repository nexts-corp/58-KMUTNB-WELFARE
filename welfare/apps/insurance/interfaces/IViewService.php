<?php
namespace apps\insurance\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {
    /**
     * @name add
     * @uri /sso/admin/add
     * @return html view
     * @description หน้าแสดงการเพิ่มข้อมูลประกันสังคม
     */
    public function ssoAdminAdd();
    
     /**
     * @name lists
     * @uri /sso/admin/lists
     * @return html view
     * @description หน้าแสดงรายการข้อมูลประกันสังคม
     */
    public function ssoAdminLists();
    
     /**
     * @name edit
     * @uri /sso/admin/edit
     * @return html view
     * @description หน้าแก้ไขข้อมูลประกันสังคม
     */
    public function ssoAdminEdit();
    
    /**
     * @name lists
     * @uri /sso/user/lists
     * @return html view
     * @description หน้าแสดงรายการข้อมูลประกันสังคม
     */
    public function ssoUserLists();
    
    
    
 
    
}
