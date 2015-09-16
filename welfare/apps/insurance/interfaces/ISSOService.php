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
}
