<?php

namespace apps\welfare\interfaces;

/**
 * @name welfare
 * @uri /history
 * @description จัดการ ตรวจสอบรายการผู้เคยใช้สิทธิ์
 */

interface IHistoryService {

     /**
     * @name preview
     * @uri /preview/history
     * @param apps\welfare\entity\History data []
     * @return string preview
     * @description test
     */
    public function preview($data);
    
    
}
