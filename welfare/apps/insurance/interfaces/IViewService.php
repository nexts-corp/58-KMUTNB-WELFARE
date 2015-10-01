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
     * @name lists
     * @uri /sso/user/lists
     * @return html view
     * @description หน้าแสดงรายการข้อมูลประกันสังคม
     */
    public function ssoUserLists();

    /**
     * @name lists
     * @uri /life/admin/lists
     * @return html view
     * @description หน้าแสดงรายการข้อมูลประกันกลุ่ม
     */
    public function lifeAdminLists();
    
       /**
     * @name lists
     * @uri /life/user/lists
     * @return html view
     * @description หน้าแสดงรายการข้อมูลประกันกลุ่ม
     */
    public function lifeUserLists();
    
    /**
     * @name addBeneficiary
     * @uri /beneficiary/add
     * @param string lifeId 
     * @return string beneficiaryAdd
     * @description หน้าแสดงการเพิ่มข้อมูลผู้รับผลประโยชน์
     */
    public function addBeneficiary($lifeId);
    
    /**
     * @name editBeneficiary
     * @uri /beneficiary/edit
     * @param string lifeId
     * @return string beneficiaryAdd
     * @description หน้าแสดงการแก้ไขข้อมูลผู้รับผลประโยชน์
     */
    public function editBeneficiary($lifeId);
    
    /**
     * @name beneficiary
     * @uri /beneficiary/list
     * @param string lifeId 
     * @return string listBeneficiary
     * @description หน้าแสดงการแก้ไขข้อมูลผู้รับผลประโยชน์
     */
    public function beneficiary($lifeId);
}
