<?php
namespace apps\retire\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {
    /**
     * @name viewList
     * @uri /retire/list
     * @return html viewList xxx
     * @description หน้าแสดงรายการผู้เกษียนอายุ
     */
    public function retireList();

    
}
