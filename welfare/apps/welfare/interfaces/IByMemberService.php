<?php

namespace apps\welfare\interfaces;

/**
 * @name welfare
 * @uri /member
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลสวัสดิการ
 */
interface IByMemberService {

    /**
     * @name save
     * @uri /save
     * @param apps\welfare\entity\Welfare data []
     * @return boolean save [return ture or false if don't ]
     * @description save เพิ่มข้อมูลสวัสดิการ
     */
    public function save($data);
    
    /**
     * @name updatewelfare
     * @uri /update
     * @param apps\welfare\entity\Welfare data []
     * @return boolean update [return ture or false if don't ]
     * @description update แก้ไขข้อมูลสวัสดิการ
     */
    public function update($data);

    /**
     * @name deletewelfare
     * @uri /delete
     * @param integer Id Description
     * @return boolean delete [return ture or false if don't ]
     * @description delete ลบข้อมูลสวัสดิการ
     */
    public function delete($Id);
    
}
