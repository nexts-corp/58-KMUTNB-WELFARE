<?php

namespace apps\qa\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {

    /**
     * @name questionsList
     * @uri /questions/lists
     * @return html viewList xxx
     * @description หน้าแสดงรายการข่าวสาร
     */
    public function questionsList();

    /**
     * @name questionsadd
     * @uri /questions/add
     * @return html viewadd xxx
     * @description แสดงการเพิ่มข่าวสาร
     */
    public function questionsAdd();

    /**
     * @name viewedit
     * @uri /questions/edit
     * @return html questionsEdit Description
     * @description view แก้ไขข้อมูลข่าวสาร
     */
    public function questionsEdit();
    
    /**
     * @name contactUs
     * @uri /contactUs
     * @return html contactUs 
     * @description view ติดต่อ
     */
    public function contactUs();
}
