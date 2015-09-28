<?php
namespace apps\news\interfaces;
/**
 * @name INewsService
 * @uri /manage
 * @description จัดการกลุ่มสมาชิก
 */
interface INewsService {

      /**
     * @name save
     * @uri /save
     * @param apps\news\entity\News news []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มข่าว
     */
    public function save($news);
    
    /**
     * @name update
     * @uri /update
     * @param apps\news\entity\News news []
     * @return boolean update [return ture or false if don't ]  Description
     * @description แก้ไขข่าว  
     */
    public function update($news);
    
    
    /**
     * @name deletenews
     * @uri /delete
     * @param string newsId
     * @return string delete
     * @description view deleteRegister   
     */
    public function delete($newsId);
    
    
     
    /**
     * @name update
     * @uri /nft/update
     * @param apps\common\entity\Nottifications ntf []
     * @return boolean update [return ture or false if don't ]  Description
     * @description แก้ไข nottifications  
     */
    public function ntfUpdate($nft);
    
}
