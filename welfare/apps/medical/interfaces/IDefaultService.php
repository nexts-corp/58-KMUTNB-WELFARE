<?php
namespace apps\medical\interfaces;
/**
 * @name medicalfee
 * @uri /default
 * @description จัดการ เพิ่ม/แก้ไข การตั้งค่ารักษาพยาบาล
 */
interface IDefaultService {
    
    /**
     * @name savemedical
     * @uri /save
     * @param apps\common\entity\SettingMedicalFee data []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มการตั้งค่ารักษาพยาบาล
     */
    public function save($data);
}
