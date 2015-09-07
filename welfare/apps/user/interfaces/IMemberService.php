<?php

namespace apps\user\interfaces;

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
     * @param string data
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
     * @name getDepartment
     * @uri /get/department
     * @param integer facultyId Description
     * @return html department Description
     * @description view department   
     */
    public function getDepartment($id);

    /**
     * @name getDepartment
     * @uri /get/datas/department
     * @param integer facultyId Description
     * @return html department Description
     * @description view department   
     */
    public function getData($id);
    
    /**
     * @name search
     * @uri /search
     * @param String SearchName 
     * @return string search Description
     * @description ค้นหา   
     */
    public function search($data);
    
    /**
     * @name changePassword
     * @uri /change/password
     * @param string data
     * @return boolean update Description
     * @description view list new
     */
    public function changePassword($data);
}
