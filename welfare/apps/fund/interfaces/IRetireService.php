<?php

namespace apps\fund\interfaces;

/**
 * @name retire
 * @uri /retire
 * @description กองทุนสำหรับพนักงานมหาวิทยาลัย
 */
interface IRetireService {

    
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
     * @return string save
     * @description บันทึกข้อมูลประกันสังคม
     */
    public function save();
    
}
