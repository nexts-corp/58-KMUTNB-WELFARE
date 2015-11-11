<?php

namespace apps\welfare\interfaces;

/**
 * @name IViewUserService
 * @uri /view/user
 * @description แสดงผล 
 * 
 */
interface IViewUserService {

    /**
     * @name lists
     * @uri /lists
     * @return html view
     * @description จัดการรายการสวัสดิการ
     */
    public function lists();
    
    /**
     * @name checkWelfare
     * @uri /check/welfare
     * @return string right
     * @description ตรวจสอบสิทธิ์สวัสดิการ
     */
    public function checkWelfare();
}
