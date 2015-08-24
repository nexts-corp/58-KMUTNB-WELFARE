<?php

namespace apps\basics\interfaces;
/**
 * @name IPositionsService
 * @uri /positions
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ตำแหน่งงาน 
 */
interface IPositionsService {

 
    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Positions data []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มตำแหน่งงาน
     */
    public function save($data);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Positions data Description
     * @return boolean update Description
     * @description แก้ไขตำแหน่งงาน
     */
    public function update($data);
     
    /**
     * @name delete
     * @uri /delete
     * @param integer Id Description
     * @return string delete Description
     * @description ลบตำแหน่งงาน
     */
    public function delete($Id);
    
}
