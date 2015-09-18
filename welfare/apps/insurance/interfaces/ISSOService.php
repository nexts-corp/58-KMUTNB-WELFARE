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
}
