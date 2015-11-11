<?php

namespace apps\welfare\interfaces;

/**
 * @name IHistoryService
 * @uri /history
 * @description จัดการ ตรวจสอบรายการผู้เคยใช้สิทธิ์
 */

interface IHistoryService {

     /**
     * @name save
     * @uri /save
     * @param apps\welfare\entity\History data []
     * @return boolean save [return ture or false if don't ]
     * @description save เพิ่มการใช้งาน
     */
    public function save($data);
    
     /**
     * @name update
     * @uri /update
     * @param apps\welfare\entity\History data []
     * @return boolean update [return ture or false if don't ]
     * @description update แก้ไขการใช้งาน
     */
    public function update($data);
    
     /**
     * @name delete
     * @uri /delete
     * @param integer Id Description
     * @return boolean delete [return ture or false if don't ]
     * @description delete ลบข้อมูล
     */
    public function delete($Id);
    
    
    /**
     * @name getHistory
     * @uri /get/history
     * @param apps\welfare\entity\History data []
     * @return string history
     * @description แสดงรายละเอียดการใช้ สวัสดิการ 
     */
    public function getHistory($data);
    
       /**
     * @name checkApprove
     * @uri /check/approve
     * @return string history
     * @description test
     */
    public function checkApprove();
    
        /**
     * @name checkStatus
     * @param string data 
     * @uri /check/status
     * @return string history
     * @description test
     */
    public function checkStatus($data);
    
     
     
}
