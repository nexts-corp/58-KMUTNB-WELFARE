<?php

namespace apps\menu\interfaces;

/**
 * @name View
 * @uri /view
 * @description แสดง
 */
interface IViewService {

    /**
     * @name header
     * @uri /header
     * @return html view
     * @description เรียก head menu มาแสดง
     * @authen true
     */
    public function header();
    
    /**
     * @name menu/admin
     * @uri /menu/admin
     * @return html view
     * @description เรียก head menu มาแสดง
     * @authen true
     */
    public function admin();
    /**
     * @name menu/member
     * @uri /menu/member
     * @return html view
     * @description เรียก head menu มาแสดง
     * @authen true
     */
    public function member();
    
    /**
     * @name menu/department
     * @uri /menu/department
     * @return html view
     * @description เรียก head menu มาแสดง
     * @authen true
     */
    public function department();
    
    /**
     * @name menu/faculty
     * @uri /menu/faculty
     * @return html view
     * @description เรียก head menu มาแสดง
     */
    public function faculty();
    
     /**
     * @name menu/medical
     * @uri /menu/medical
     * @return html view
     * @description เรียก head menu มาแสดง
     */
    public function medical();
    
    
}
