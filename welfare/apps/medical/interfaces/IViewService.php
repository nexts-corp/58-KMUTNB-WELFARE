<?php

namespace apps\medical\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {
//        
//    /**
//     * @name defultAdd
//     * @uri /defult/add
//     * @return html view
//     * @description view ตั้งค่าการรักษาพยาบาลเบื้องต้น 20,000 บาท  
//     */
//    public function defultAdd();



    /**
     * @name medicalFeeLists
     * @uri /medicalFee/lists
     * @return html view
     * @description รายการข้อมูลการเบิกค่ารักษาพยาบาล
     */
    
    public function medicalFeeLists();

    /**
     * @name medicalFeeAdd
     * @uri /medicalFee/add
     * @return html view
     * @description view เพิ่มข้อมูลการเบิกค่ารักษาพยาบาล  
     */
    public function medicalFeeAdd();

//    /**
//     * @name medicalFeeEdit
//     * @uri /medicalFee/edit
//     * @param integer id
//     * @return html view
//     * @description view แก้ไขข้อมูลการเบิกค่ารักษาพยาบาล
//     */
//    public function medicalFeeEdit($id);
//     
//
//    
//    /**
//     * @name reportLists
//     * @uri /report/lists
//     * @param integer id
//     * @return html view
//     * @description รายการภาควิชาหรือสำนักงาน
//     */
//    public function reportLists();

    
   

}
