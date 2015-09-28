<?php
namespace apps\qa\interfaces;
/**
 * @name qa
 * @uri /questions
 * @description จัดการกลุ่มสมาชิก
 */
interface IQuestionsService {

      /**
     * @name save
     * @uri /save
     * @param apps\qa\entity\Questions datas []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มข่าว
     */
    public function save($datas);
    
    /**
     * @name update
     * @uri /update
     * @param apps\qa\entity\Questions datas []
     * @return boolean update [return ture or false if don't ]  Description
     * @description แก้ไขข่าว  
     */
    public function update($datas);
    
    /**
     * @name deletequestions
     * @uri /delete
     * @param string questionsId
     * @return string delete
     * @description view deleteRegister   
     */
    public function delete($questionsId);
    
}
