<?php

namespace apps\medical\interfaces;

/**
 * @name medicalfee
 * @uri /medicalfee
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลการตั้งค่ารักษาพยาบาล
 */
interface IMedicalFeeService {

    /**
     * @name medicallist
     * @uri /medicallist
     * @param string retireYear
     * @return string retireyear
     * @description test
     */
    public function medicallist($retireYear);
    
    /**
     * @name searchuser
     * @uri /search/user
     * @param string idCard
     * @return string searchUser
     * @description test
     */
    public function searchUser($idCard);
    
    /**
     * @name save
     * @uri /save
     * @param apps\welfare\entity\History data []
     * @return boolean save [return ture or false if don't ]
     * @description save data to database
     */
    public function save($data);
    
    /**
     * @name search
     * @uri /search
     * @param string data
     * @return string search Description
     * @description ค้นหา   
     */
    public function search($data);
    
    /**
     * @name update
     * @uri /update
     * @param apps\welfare\entity\History data Description
     * @return boolean update Description
     * @description view list new
     */
    public function update($data);
    
    /**
     * @name searchDetail
     * @uri /search/detail
     * @param string data
     * @return string search Description
     * @description ค้นหา   
     */
    public function searchDetail($data);
    
    /**
     * @name delete
     * @uri /delete
     * @param string historyId Description
     * @return boolean delete Description
     * @description view list new
     */
    public function delete($historyId);
}
