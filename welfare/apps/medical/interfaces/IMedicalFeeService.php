<?php

namespace apps\medical\interfaces;

/**
 * @name medicalfee
 * @uri /medicalfee
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลการตั้งค่ารักษาพยาบาล
 */
interface IMedicalFeeService {

    /**
     * @name medicallist
     * @uri /medicallist
     * @param string retireYear
     * @return string retireyear
     * @description test
     */
    public function medicallist($retireYear);
    
    /**
     * @name searchuser
     * @uri /search/user
     * @param string idCard
     * @return string searchUser
     * @description test
     */
    public function searchUser($idCard);
}
