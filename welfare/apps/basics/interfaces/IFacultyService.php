<?php
namespace apps\basics\interfaces;
  /**
     * @name IFacultyService
     * @uri /faculty 
     * @return html new Description
     * @description จัดการ เพิ่ม/ลบ/แก้ไข คณะหรือสำนักงาน
     */
interface IFacultyService {
  
    
    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Faculty data []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มข้อมูลคณะหรือสำนักงาน
     */
    public function save($data);
    
    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Faculty data []
     * @return boolean update [return ture or false if don't ]
     * @description แก้ไขข้อมูลคณะหรือสำนักงาน
     */
    public function update($data);
    
    /**
     * @name delete
     * @uri /delete
     * @param interger Id Description
     * @return string delete Description
     * @description ลบข้อมูลคณะหรือสำนักงาน
     */
    public function delete($id);
   
}
