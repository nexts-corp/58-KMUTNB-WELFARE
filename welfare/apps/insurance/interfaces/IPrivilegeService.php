<?php

namespace apps\insurance\interfaces;

/**
 * @name privilege
 * @uri /privilege
 * @description จัดการข้อมูลผู้รับผลประโยชน์
 */
interface IPrivilegeService {

    
    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Privileges data []
     * @return boolean save []
     * @description บันทึกข้อมูลผู้รับผลประโยชน์
     */
    public function save($data);
    
     /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Privileges data []
     * @return boolean update []
     * @description อัพเดทข้อมูลผู้รับผลประโยชน์
     */
    public function update($data);
    
       /**
     * @name delete
     * @uri /delete
     * @param apps\common\entity\Privileges data []
     * @return boolean delete []
     * @description ลบข้อมูลผู้รับผลประโยชน์
     */
    public function delete($data);
    
    /**
     * @name viewSearch
     * @uri /view/search
     * @param String SearchName Description
     * @return html listnew Description
     * @description view viewSearch   
    */
    public function viewSearch($data);
}
