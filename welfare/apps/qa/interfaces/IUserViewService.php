<?php
namespace apps\qa\interfaces;

/**
 * @name IUserViewService
 * @uri /user/view
 * @description แสดงผล 
 */
interface IUserViewService {
    /**
     * @name qaList
     * @uri /questions/lists
     * @return html viewList xxx
     * @description หน้าแสดงรายคำถาม
     */
    public function qaList();
    
  /**
     * @name questionsadd
     * @uri /questions/add
     * @return html viewadd xxx
     * @description แสดงการเพิ่มข่าวสาร
     */
    public function questionsAdd();
    
     /**
     * @name qaRead
     * @uri /qa/read
     * @return html fileList 
     * @description รายการคำถาม
     */
    public function qaRead();
    
   
    
}
