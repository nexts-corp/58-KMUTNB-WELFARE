<?php

namespace apps\member\interfaces;

/**
 * @name member
 * @uri /member
 * @return html member Description
 * @description จัดการบุคคลากร
 */
interface IMemberService {


    /**
     * @name save
     * @uri /save
     * @param apps\member\entity\Member data []
     * @return boolean save [return ture or false if don't ]
     * @description save data to database
     */
    public function save($data);

    /**
     * @name update
     * @uri /update
     * @param apps\member\entity\Member data Description
     * @return boolean update Description
     * @description view list new
     */
    public function update($data);

    /**
     * @name deleteRegister
     * @uri /delete
     * @param integer memberId
     * @return string delete
     * @description view deleteRegister   
     */
    public function delete($memberId);

    /**
     * @name search
     * @uri /search
     * @param string data
     * @return string search Description
     * @description ค้นหา   
     */
    public function search($data);
    
    /**
     * @name find
     * @uri /find
     * @param string field
     * @param string value
     * @return string find
     * @description ค้นหา   
     */
    public function find($field,$value);
    
    /**
     * @name reference
     * @uri /reference
     * @param file file
     * @return string upload
     * @description อัพโหลดไฟล์ pdf,jpg,gif
     */
    public function reference($file);
    
    /**
     * @name upload
     * @uri /upload
     * @param file file
     * @return string upload
     * @description อัพโหลดไฟล์ csv
     */
    public function upload($file);
    
    
    
}