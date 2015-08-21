<?php
namespace apps\medical\interfaces;
/**
 * @name medicalfee
 * @uri /medicalfee
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลการตั้งค่ารักษาพยาบาล
 */
interface IMedicalFeeService {
    
    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\MedicalFee data []
     * @return html save Description
     * @description เพิ่มข้อมูลการตั้งค่ารักษาพยาบาล
     */
    public function save($data);

    /**
     * @name deletetitleName
     * @uri /delete
     * @param integer Id Description
     * @return string deletetitleName Description
     * @description ลบข้อมูลการตั้งค่ารักษาพยาบาล
     */
    public function delete($Id);
    
    /**
     * @name insert
     * @uri /insert
     * @param apps\common\entity\MedicalFee data []
     * @return string insert Description
     * @description แก้ไขข้อมูลการตั้งค่ารักษาพยาบาล
     */
    public function edit($data);
    

}
