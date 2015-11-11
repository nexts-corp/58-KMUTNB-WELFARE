<?php

namespace apps\welfare\interfaces;

/**
 * @name IByMemberService
 * @uri /bymember
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลสวัสดิการ
 */
interface IByMemberService {

    /**
     * @name save
     * @uri /save
     * @param apps\welfare\entity\Welfare data []
     * @return boolean save [return ture or false if don't ]
     * @description save เพิ่มข้อมูลสวัสดิการรายบุคคล
     */
    public function save($data);
    
    /**
     * @name update
     * @uri /update
     * @param apps\welfare\entity\Welfare data []
     * @return boolean update [return ture or false if don't ]
     * @description update แก้ไขสวัสดิการรายบุคคล
     */
    public function update($data);

    /**
     * @name delete
     * @uri /delete
     * @param integer Id Description
     * @return boolean delete [return ture or false if don't ]
     * @description delete ลบสวัสดิการรายบุคคล
     */
    public function delete($Id);
    
     /**
     * @name getReport
     * @uri /get/report
     * @param apps\welfare\entity\History data []
     * @return string report
     * @description ออกรีพอร์ท
     */
    public function getReport($data);
}
