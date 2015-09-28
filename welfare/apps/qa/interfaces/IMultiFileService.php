<?php
namespace apps\qa\interfaces;
/**
 * @name IMultiFileService
 * @uri /multifile
 * @description จัดการภาพ
 */
interface IMultiFileService {
    
    
    
     /**
     * @name save
     * @uri /save
     * @param  file file 
     * @return string url
     * @description เพิ่มภาพ
     */
    public function save($file);
    
    /**
     * @name delete
     * @uri /delete
     * @param integer id Description
     * @return boolean delete [return ture or false if don't ]  
     * @description ลบภาพ 
     */
    public function delete($id);
    
}
