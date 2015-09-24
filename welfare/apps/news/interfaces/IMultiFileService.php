<?php
namespace apps\news\interfaces;
/**
 * @name news
 * @uri /multifile
 * @description จัดการภาพ
 */
interface IMultiFileService {
    
     /**
     * @name save
     * @uri /save
     * @param apps\news\common\entity\MultiFile file []
     * @return string url
     * @description เพิ่มภาพ
     */
    public function save($file);
    
    /**
     * @name update
     * @uri /update
     * @param apps\news\common\entity\MultiFile data []
     * @return boolean update [return ture or false if don't ]  Description
     * @description แก้ไขภาพ  
     */
    public function update($data);
     
    /**
     * @name delete
     * @uri /delete
     * @param integer id Description
     * @return boolean delete [return ture or false if don't ]  
     * @description ลบภาพ 
     */
    public function delete($id);
    
}
