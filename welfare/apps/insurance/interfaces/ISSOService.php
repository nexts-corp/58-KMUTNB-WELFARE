<?php

namespace apps\insurance\interfaces;

/**
 * @name sso
 * @uri /sso
 * @description อัพโหลดเอกสาร
 */
interface ISSOService {

    
    /**
     * @name lists
     * @uri /lists
     * @return string lists
     * @description ลิสต์ข้อมูลผู้ประกันตนประกันสังคม
     */
    public function lists();
    
    /**
     * @name save
     * @uri /save
     * @param apps\insurance\entity\SSO sso
     * @return string save
     * @description บันทึกข้อมูลประกันสังคม
     */
    public function save($sso);
    
    /**
     * @name ChangeHospital
     * @uri /change/hospital
     * @param apps\insurance\entity\SSOHospital ssoHospital
     * @return string change
     * @description เปลี่ยนสถานพยาบาล
     */
    public function changeHospital($ssoHospital);
    
    /**
     * @name searchsso
     * @uri /search/sso
     * @param string searchName
     * @return string searchName
     * @description การค้นหาข้อมูลกองทุนเพื่อการเลี้ยงชีพ 
     */
    public function searchsso($searchName);
}
