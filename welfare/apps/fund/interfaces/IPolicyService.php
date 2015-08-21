<?php
namespace apps\ManagementFund\interfaces;

/**
 * @name policy
 * @uri /policy
 * @description จัดการข้อมูลนโยบาย
 */
interface IPolicyService {
    /**
     * @name viewList
     * @uri /list
     * @return html viewList xxx
     * @description หน้าแสดงรายการข้อมูลประกันสังคม
     */
    public function viewList();
    
    /**
     * @name viewAddPrivilege
     * @uri /view/add
     * 
     * @return html viewAddPrivilege Description
     * @description view Add Privilege  
     */
    public function viewAdd();
    
    /**
     * @name addpolicy
     * @uri /save
     * @param apps\common\entity\Policy data []
     * @return boolean save [return ture or false if don't ]
     * @description save data to database
     */
    public function save($data);
    
    /**
     * @name viewedit
     * @uri /edit
     * @param String policyId Description
     * @return string editfaculty Description
     * @description edit Faculty
     */
    public function viewEdit($policyId);
    
    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Policy data []
     * @return boolean save [return ture or false if don't ]
     * @description edit FacultySave
     */
    public function update($data);
    
    /**
     * @name viewSearch
     * @uri /view/search
     * @param String SearchName Description
     * @return html listnew Description
     * @description view fromEditPositionAcademic   
    */
    public function viewSearch($data);
}
