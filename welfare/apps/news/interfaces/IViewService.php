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
    public function newsAdd();
    
      /**
     * @name viewedit
     * @uri /news/edit
     * @return html newsEdit Description
     * @description view แก้ไขข้อมูลข่าวสาร
     */
    public function newsEdit();
    
     /**
     * @name fileList
     * @uri /file/list
     * @return html fileList 
     * @description หน้าแสดงรายการไฟล์
     */
    public function fileList();
    
}
