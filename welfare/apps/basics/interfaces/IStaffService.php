<?php

namespace apps\basics\interfaces;
/**
 * @name StaffService
 * @uri /staff
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลประเภทตำพนักงาน
 */
interface IStaffService {
    
    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Staff data []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มข้อมูลประเภทพนักงาน
     */
    public function save($data);

    /**
     * @name editStaff
     * @uri /update
     * @param apps\common\entity\Staff data Description
     * @return boolean update [return ture or false if don't ]
     * @description แก้ไขข้อมูลประเภทพนักงาน
     */
    public function update($data);
     
    /**
     * @name delete
     * @uri /delete
     * @param integer Id Description
     * @return boolean delete [return ture or false if don't ]
     * @description ลบข้อมูลประเภทพนักงาน
     */
    public function delete($Id);
    
}
