<?php

namespace apps\user\interfaces;

/**
 * @name ITypeService
 * @uri /type
 * @description กลุ่มประเภทผู้ใช้งาน 
 */
interface ITypeService {

    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\UserType data []
     * @return boolean save [return ture or false if don't ]
     * @description save data to database
     */
    public function save($data);

    /**
     * @name editType
     * @uri /update
     * @param apps\common\entity\UserType data Description
     * @return boolean update Description
     * @description view list new
     */
    public function update($data);

    /**
     * @name delete
     * @uri /delete
     * @param String userTypeId Description
     * @return string userType Description
     * @description delete userTypeId
     */
    public function delete($userTypeId);
}
