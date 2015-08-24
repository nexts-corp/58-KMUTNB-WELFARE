<?php

namespace apps\basics\interfaces;

/**
 * @name IDepartmentService
 * @uri /department
 * @return html new Description
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ภาควิชาหรือสำนักงาน 
 */
interface IDepartmentService {

    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Department data []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มภาควิชาหรือสำนักงาน
     */
    public function save($data);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Department data []
     * @return boolean update [return ture or false if don't ]
     * @description แก้ไขภาควิชาหรือสำนักงาน
     */
    public function update($data);
    
    /**
     * @name delete
     * @uri /delete
     * @param integer id Description
     * @return boolean delete [return ture or false if don't ]
     * @description ลบภาควิชาหรือสำนักงาน
     */
    public function delete($id);
    

}
