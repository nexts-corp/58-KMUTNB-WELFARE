<?php
namespace apps\news\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {
    /**
     * @name newsList
     * @uri /news/list
     * @return html viewList xxx
     * @description หน้าแสดงรายการข่าวสาร
     */
    public function newsList();
    
    /**
     * @name newsadd
     * @uri /news/add
     * @return html viewadd xxx
     * @description แสดงการเพิ่มข่าวสาร
     */
    public function newsadd();
}
