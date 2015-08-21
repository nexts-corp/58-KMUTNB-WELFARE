<?php
namespace apps\member\interfaces;
/**
 * @name family
 * @uri /family
 * @return html member Description
 * @description จัดการผู้มีความสัมพันธ์
 */
interface IFamilyService {

    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Family data []
     * @return boolean save [return ture or false if don't ]
     * @description save data to database
     */
    public function save($data);

    /**
     * @name updateFamily
     * @uri /update
     * @param apps\common\entity\Family data []
     * @return boolean update [return ture or false if don't ]
     * @description save data update to database
     */
    public function update($data);
    
     /**
     * @name delete
     * @uri /delete
     * @param String familyId Description
     * @return string familyId Description
     * @description familyId
     */
    public function delete($familyId);
}
