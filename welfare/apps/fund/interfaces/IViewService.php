<?php

namespace apps\fund\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {
        
    /**
     * @name cooperativeLists
     * @uri /cooperative/lists
     * @return html view
     * @description รายการข้อมูลกองทุนสำรองเลี้ยงชีพ(สหกรณ์)
     */
    public function cooperativeLists();

    /**
     * @name cooperativeAdd
     * @uri /cooperative/add
     * @return html view
     * @description view เพิ่มข้อมูลกองทุนสำรองเลี้ยงชีพ(สหกรณ์) 
     */
    public function cooperativeAdd();
  
    

    /**
     * @name liveLists
     * @uri /live/lists
     * @return html view
     * @description รายการคณะหรือสำนักงาน
     */
    public function liveLists();

    /**
     * @name liveAdd
     * @uri /live/add
     * @return html view
     * @description view เพิ่มคณะหรือสำนักงาน  
     */
    public function liveAdd();

    /**
     * @name liveEdit
     * @uri /live/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขคณะหรือสำนักงาน 
     */
    public function liveEdit($id);
    
    // end view live
    
    /**
     * @name retireLists
     * @uri /retire/lists
     
     * @return html view
     * @description รายการภาควิชาหรือสำนักงาน
     */
    public function retireLists();

    /**
     * @name retireAdd
     * @uri /retire/add
     * @param integer id
     * @return html view
     * @description view เพิ่มภาควิชาหรือสำนักงาน 
     */
    public function retireAdd($id);

    /**
     * @name retireEdit
     * @uri /retire/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขภาควิชาหรือสำนักงาน  
     */
    public function retireEdit($id);
    
    //end view retire 
    
    /**
     * @name policyLists
     * @uri /policy/lists
     * @return html view
     * @description รายการประเภทพนักงาน
     */
    public function policyLists();

    /**
     * @name policyAdd
     * @uri /policy/add
     * @return html view
     * @description view เพิ่มประเภทพนักงาน
     */
    public function policyAdd();

    /**
     * @name policyEdit
     * @uri /policy/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขประเภทพนักงาน 
     */
    public function policyEdit($id);
    
    //end view policy 
      
   
   
    

}
