<?php

namespace apps\welfare\interfaces;

/**
 * @name IViewAdminService
 * @uri /view/admin
 * @description แสดงผล 
 * 
 */
interface IViewAdminService {

    /**
     * @name lists
     * @uri /welfare/lists
     * @return html view
     * @description จัดการรายการสวัสดิการ
     */
    public function welfareLists();
    
     /**
     * @name approveLists
     * @uri /approve/lists
     * @return html view
     * @description จัดการรายการสวัสดิการ
     */
    public function approveLists();


    /**
     * @name add
     * @uri /welfare/add
     * @return html view
     * @description จัดการรายการสวัสดิการ
     */
    public function welfareAdd();

    /**
     * @name edit
     * @uri /welfare/edit
     * @return html view
     * @description จัดการรายการสวัสดิการ
     */
    public function welfareEdit();
}
