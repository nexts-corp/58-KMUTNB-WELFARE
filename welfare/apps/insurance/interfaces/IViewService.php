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
     * @uri /sso/add
     * @return html view
     * @description หน้าแสดงการเพิ่มข้อมูลประกันสังคม
     */
    public function ssoAdd();
    
     /**
     * @name lists
     * @uri /sso/lists
     * @return html view
     * @description หน้าแสดงรายการข้อมูลประกันสังคม
     */
    public function ssoLists();
    
     /**
     * @name edit
     * @uri /sso/edit
     * @return html view
     * @description หน้าแก้ไขข้อมูลประกันสังคม
     */
    public function ssoEdit();
    
       /**
     * @name upload
     * @uri /sso/upload
     * @return html view
     * @description หน้าแก้ไขข้อมูลประกันสังคม
     */
    public function ssoUpload();
    
 
    
}
