<?php
namespace apps\basics\interfaces;
/**
     * @name TitleName
     * @uri /title
     * @return html TitleName Description
     * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลคำนำหน้าชื่อ
     */
interface ITitleNameService {
   
    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\TitleName data []
     * @return html save Description
     * @description เพิ่มคำนำหน้าชื่อ
     */
    public function save($data);
    
    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\TitleName data []
     * @return boolean update [return ture or false if don't ]
     * @description แก้ไขคำนำหน้าชื่อ
     */
    public function update($data);
    
     /**
     * @name delete
     * @uri /delete
     * @param integer id Description
     * @return string deletetitleName Description
     * @description ลบคำนำหน้าชื่อ
     */
    public function delete($id);
    
}
