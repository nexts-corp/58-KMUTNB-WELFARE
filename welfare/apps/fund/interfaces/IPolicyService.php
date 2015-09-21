<?php

namespace apps\fund\interfaces;

/**
 * @name policy
 * @uri /policy
 * @description จัดการข้อมูลนโยบาย
 */
interface IPolicyService {

    /**
     * @name save
     * @uri /save
     * @param apps\fund\entity\Policy policy
     * @return boolean save
     * @description save data to database
     */
    public function save($policy);
    
     /**
     * @name update
     * @uri /update
     * @param apps\fund\entity\Policy policy
     * @return boolean update
     * @description save data to database
     */
    public function update($policy);
}
