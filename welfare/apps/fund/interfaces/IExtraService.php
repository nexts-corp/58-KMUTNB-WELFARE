<?php

namespace apps\fund\interfaces;

/**
 * @name extra
 * @uri /extra
 * @description กองทุนสำหรับพนักงานมหาวิทยาลัย
 */
interface IExtraService {

    
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
    
    /**
     * @name searchext
     * @uri /search/extra
     * @param string searchName
     * @return string searchName
     * @description การค้นหาข้อมูลกองทุนเพื่อการเลี้ยงชีพ 
     */
    public function searchext($searchName);
    
}
