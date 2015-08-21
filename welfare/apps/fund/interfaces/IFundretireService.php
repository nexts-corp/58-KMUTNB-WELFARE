<?php
namespace apps\ManagementFund\interfaces;
/**
 * @name fundretire
 * @uri /fundretire
 * @description จัดการข้อมูลประกันสังคม
 */

interface IFundretireService {
    /**
     * @name viewList
     * @uri /list
     * @return html viewList xxx
     * @description หน้าแสดงรายการข้อมูลประกันสังคม
     */
    public function viewList();
    
    /**
     * @name viewListdetail
     * @uri /list/detail
     * @return html viewList xxx
     * @description หน้าแสดงรายการข้อมูลประกันสังคม
     */
    public function viewListdetail();
    
    /**
     * @name viewAddfundlive
     * @uri /view/add
     * 
     * @return html viewAddfundlive Description
     * @description view Add Privilege  
     */
    public function viewAdd();
    
    /**
     * @name viewAdddetail
     * @uri /add/detail
     * 
     * @return html viewAdddetail Description
     * @description view Add Privilege  
     */
    public function viewAdddetail();
}
