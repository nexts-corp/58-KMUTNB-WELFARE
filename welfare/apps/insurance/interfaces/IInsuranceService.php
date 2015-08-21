<?php

namespace apps\insurance\interfaces;

/**
 * @name insurance
 * @uri /insurance
 * @description จัดการข้อมูลประกันสังคม
 */
interface IInsuranceService {

    /**
     * @name viewSearch
     * @uri /view/search
     * @param String SearchName Description
     * @return html listnew Description
     * @description view viewSearch   
    */
    public function viewSearch($data);
    
    
    /**
     * @name viewSearchlist
     * @uri /view/searchlist
     * @param String SearchName Description
     * @return html listnew Description
     * @description view viewSearch   
    */
    public function viewSearchlist($data);
    
    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Insurance data []
     * @return boolean save []
     * @description บันทึกข้อมูลประกันสังคม
     */
    public function save($data);
}
