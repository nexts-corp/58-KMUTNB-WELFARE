<?php

namespace apps\insurance\interfaces;

/**
 * @name life
 * @uri /life
 * @description อัพโหลดเอกสาร
 */
interface ILifeService {

    /**
     * @name lists
     * @uri /lists
     * @return string lists
     * @description ลิสต์ข้อมูลผู้ประกันกลุ่ม
     */
    public function lists();
    
    /**
     * @name update
     * @uri /update
     * @param apps\insurance\entity\Life life
     * @return string update
     * @description ลิสต์ข้อมูลผู้ประกันกลุ่ม
     */
    public function update($life);
}
