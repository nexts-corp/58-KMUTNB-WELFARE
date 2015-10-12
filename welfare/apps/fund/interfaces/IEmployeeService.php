<?php

namespace apps\fund\interfaces;

/**
 * @name employee
 * @uri /employee
 * @description กองทุนสำหรับพนักงานมหาวิทยาลัย
 */
interface IEmployeeService {

    
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
     * @name ChangeHospital
     * @uri /change/hospital
     * @param apps\insurance\entity\SSOHospital employeeHospital
     * @return string change
     * @description เปลี่ยนสถานพยาบาล
     */
    public function changeHospital($employeeHospital);
    
    /**
     * @name searchemp
     * @uri /search/employee
     * @param string searchName
     * @return string searchName
     * @description การค้นหาข้อมูลกองทุนสำรองเลี้ยงชีพ 
     */
    public function searchemp($searchName);
}
