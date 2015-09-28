<?php
namespace apps\qa\interfaces;

/**
 * @name IAnswerService
 * @uri /answer
 * @description แสดงผล 
 */
interface IAnswerService {
   
    /**
     * @name save
     * @uri /save
     * @param apps\qa\entity\Answer datas []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มคำตอบ
     */
    public function save($datas);
   
   
    
   
    
}
