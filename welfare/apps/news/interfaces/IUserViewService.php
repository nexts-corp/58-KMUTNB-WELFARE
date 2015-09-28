<?php
namespace apps\news\interfaces;

/**
 * @name IUserViewService
 * @uri /user/view
 * @description แสดงผล 
 */
interface IUserViewService {
    /**
     * @name newsList
     * @uri /news/lists
     * @return html viewList xxx
     * @description หน้าแสดงรายการข่าวสาร
     */
    public function newsList();
    
  
    
     /**
     * @name fileList
     * @uri /news/read
     * @return html fileList 
     * @description อ่านข่าว
     */
    public function newsRead();
    
   
    
}
