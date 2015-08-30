<?php

namespace apps\welfare\interfaces;

/**
 * @name welfare
 * @uri /condition
 * @description จัดการ เพิ่ม/ลบ/แก้ไข เงื่อนไขสวัสดิการ
 */
interface IConditionService {

    /**
     * @name save
     * @uri /save
     * @param apps\welfare\entity\Condition data []
     * @return boolean save [return ture or false if don't ]
     * @description save เพิ่มเงื่อนไขสวัสดิการ
     */
    public function save($data);
    
    /**
     * @name updatewelfare
     * @uri /update
     * @param apps\welfare\entity\Condition data []
     * @return boolean update [return ture or false if don't ]
     * @description update แก้ไขเงื่อนไขสวัสดิการ
     */
    public function update($data);

    /**
     * @name deletewelfare
     * @uri /delete
     * @param integer Id Description
     * @return boolean delete [return ture or false if don't ]
     * @description delete ลบเงื่อนไขสวัสดิการ
     */
    public function delete($Id);
    
}
