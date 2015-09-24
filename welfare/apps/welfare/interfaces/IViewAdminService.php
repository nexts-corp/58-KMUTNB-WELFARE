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
     * @name lists
     * @uri /welfare/add
     * @return html view
     * @description จัดการรายการสวัสดิการ
     */
    public function welfareAdd();
 
    
    
}
