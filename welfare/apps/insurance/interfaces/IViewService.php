<?php
namespace apps\insurance\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {
    /**
     * @name insuranceList
     * @uri /insurance/list
     * @return html viewList xxx
     * @description หน้าแสดงรายการข้อมูลประกันสังคม
     */
    public function insuranceList();
    
    /**
     * @name insuranceAdd
     * @uri /insurance/add
     * 
     * @return html viewAddPrivilege Description
     * @description หน้าแสดงการเพิ่มข้อมูลประกันสังคม  
     */
    public function insuranceAdd();
    
    /**
     * @name privilegeList
     * @uri /privilege/list
     * @return html viewList xxx
     * @description หน้าแสดงรายการสมาชิก
     */
    public function privilegeList();
    
    /**
     * @name privilegeAdd
     * @uri /privilege/add
     * @param string registerId Description
     * @return html privilegeAdd Description
     * @description หน้าแสดงการเพิ่มผู้รับผลประโยขน์  
     */
    public function privilegeAdd($registerId);
    
    /**
     * @name privilegeEdit
     * @uri /privilege/edit
     * @param string familyId Description
     * @return html privilegeEdit Description
     * @description หน้าแสดงการแก้ไขผู้รับผลปรโยชน์  
     */
    public function privilegeEdit($familyId);
    
    /**
     * @name Privilegedetail
     * @uri /privilege/detail
     * @param Int registerId Description
     * @return html listPrivilege Description
     * @description หน้าแสดงรายการผู้รับผลประโยชน์
     */
    public function Privilegedetail($registerId);
    
    /**
     * @name socialsecurityList
     * @uri /social/security/list
     * @return html socialsecurityList
     * @description หน้าแสดงรายการจัดการข้อมูลประกันอุบติเหตุ
     */
    public function socialsecurityList();
    
}
