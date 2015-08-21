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
     * @param apps\common\entity\Register data []
     * @return boolean save [return ture or false if don't ]
     * @description save data to database
     */
    public function save($data);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Register data Description
     * @return boolean update Description
     * @description view list new
     */
    public function update($data);

    /**
     * @name deleteRegister
     * @uri /delete
     * @param integer registerId Description
     * @return html deleteRegister Description
     * @description view deleteRegister   
     */
    public function deleteRegister($registerId);

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
}
