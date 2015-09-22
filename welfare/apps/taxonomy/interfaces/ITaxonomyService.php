<?php

namespace apps\taxonomy\interfaces;

/**
 * @name taxonomy
 * @uri /taxonomy
 * @description ไรวะเนี่ย
 */
interface ITaxonomyService {

    /**
     * @name save
     * @uri /save
     * @param apps\taxonomy\entity\Taxonomy taxonomy
     * @return boolean save
     * @description save data to database
     */
    public function save($taxonomy);
    
     /**
     * @name update
     * @uri /update
     * @param apps\taxonomy\entity\Taxonomy taxonomy
     * @return boolean update
     * @description update data to database
     */
    public function update($taxonomy);
    
     /**
     * @name delete
     * @uri /delete
     * @param apps\taxonomy\entity\Taxonomy taxonomy
     * @return boolean delete
     * @description delete data to database
     */
    public function delete($taxonomy);
    
    /**
     * @name getParent
     * @uri /getParent
     * @return string lists
     * @description ลิสต์ข้อมูลพ่อ
     */
    public function getParent();
    
    /**
     * @name getPCode
     * @uri /getPCode
     * @param string pCode
     * @return string lists
     * @description ลิสต์ข้อมูลลูก pCode
     */
    public function getPCode($pCode);
    
    /**
     * @name getParentId
     * @uri /getParentId
     * @param string parentId
     * @return string lists
     * @description ลิสต์ข้อมูลลูก parentId
     */
    public function getParentId($parentId);
      /**
     * @name getCode
     * @uri /getCode
     * @param string code
     * @return string lists
     * @description ลิสต์ข้อมูลจาก code
     */
    public function getCode($code);
}
