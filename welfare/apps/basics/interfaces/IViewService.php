<?php

namespace apps\basics\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {
        
    /**
     * @name academicLists
     * @uri /academic/lists
     * @return html view
     * @description รายการตำแหน่งทางการศึกษา
     */
    public function academicLists();

    /**
     * @name academicAdd
     * @uri /academic/add
     * @return html view
     * @description view เพิ่มตำแหน่งทางการศึกษา  
     */
    public function academicAdd();

    /**
     * @name academicEdit
     * @uri /academic/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขตำแหน่งทางการศึกษา  
     */
    public function academicEdit($id);
    
    // end view academic

    /**
     * @name facultyLists
     * @uri /faculty/lists
     * @return html view
     * @description รายการคณะหรือสำนักงาน
     */
    public function facultyLists();

    /**
     * @name facultyAdd
     * @uri /faculty/add
     * @return html view
     * @description view เพิ่มคณะหรือสำนักงาน  
     */
    public function facultyAdd();

    /**
     * @name facultyEdit
     * @uri /faculty/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขคณะหรือสำนักงาน 
     */
    public function facultyEdit($id);
    
    // end view faculty
    
    /**
     * @name departmentLists
     * @uri /department/lists
     * @param integer id
     * @return html view
     * @description รายการภาควิชาหรือสำนักงาน
     */
    public function departmentLists($id);

    /**
     * @name departmentAdd
     * @uri /department/add
     * @param integer id
     * @return html view
     * @description view เพิ่มภาควิชาหรือสำนักงาน 
     */
    public function departmentAdd($id);

    /**
     * @name departmentEdit
     * @uri /department/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขภาควิชาหรือสำนักงาน  
     */
    public function departmentEdit($id);
    
    //end view department 
    
    /**
     * @name positionsLists
     * @uri /positions/lists
     * @return html view
     * @description รายการประเภทพนักงาน
     */
    public function positionsLists();

    /**
     * @name positionsAdd
     * @uri /positions/add
     * @return html view
     * @description view เพิ่มประเภทพนักงาน
     */
    public function positionsAdd();

    /**
     * @name positionsEdit
     * @uri /positions/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขประเภทพนักงาน 
     */
    public function positionsEdit($id);
    
    //end view positions 
      
    /**
     * @name staffLists
     * @uri /staff/lists
     * @return html view
     * @description รายการพนักงาน
     */
    public function staffLists();

    /**
     * @name staffAdd
     * @uri /staff/add
     * @return html view
     * @description view เพิ่มพนักงาน
     */
    public function staffAdd();

    /**
     * @name staffEdit
     * @uri /staff/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขพนักงาน 
     */
    public function staffEdit($id);
    
    //end view staff 
    
    /**
     * @name titleNameLists
     * @uri /titleName/lists
     * @return html view
     * @description รายการคำนำหน้า
     */
    public function titleNameLists();

    /**
     * @name titleNameAdd
     * @uri /titleName/add
     * @return html view
     * @description view เพิ่มคำนำหน้า
     */
    public function titleNameAdd();

    /**
     * @name titleNameEdit
     * @uri /titleName/edit
     * @param integer id
     * @return html view
     * @description view แก้ไขคำนำหน้า 
     */
    public function titleNameEdit($id);
    
    //end view titleName 


}
