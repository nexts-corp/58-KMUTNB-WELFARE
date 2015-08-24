<?php

namespace apps\welfare\interfaces;

/**
 * @name welfare
 * @uri /welfare
 * @description จัดการกลุ่มสมาชิก
 */
interface IWelfareService {

    /**
     * @name addwelfareconditions
     * @uri /save/conditions
     * @param apps\common\entity\WelfareConditions data []
     * @return boolean saveconditions [return ture or false if don't ]
     * @description save data to database
     */
    public function saveconditions($data);

    /**
     * @name Addwelfare
     * @uri /save
     * @param apps\common\entity\Welfare data []
     * @return boolean save [return ture or false if don't ]
     * @description save data to database
     */
    public function save($data);

    /**
     * @name AddSubwelfare
     * @uri /savesub/wel
     * @param apps\common\entity\WelfareSub data []
     * @return boolean savesub [return ture or false if don't ]
     * @description save data to database
     */
    public function saveSub($data);

    /**
     * @name updatewelfare
     * @uri /update
     * @param apps\common\entity\Welfare data []
     * @return boolean update [return ture or false if don't ]
     * @description save data update to database
     */
    public function update($data);

    /**
     * @name updatewelfareSub
     * @uri /updatesub
     * @param apps\common\entity\WelfareSub data []
     * @return boolean update [return ture or false if don't ]
     * @description save data update to database
     */
    public function updateSub($data);

    /**
     * @name deletewelfare
     * @uri /delete
     * @param String welfareId Description
     * @return string deletewelfare Description
     * @description delect Department
     */
    public function delete($welfareId);
    
    /**
     * @name deleteSub
     * @uri /delete/sub
     * @param String welfareSubId Description
     * @return string deletewelfare Description
     * @description delect Department
     */
    public function deleteSub($welfareSubId);

    /**
     * @name viewSearch
     * @uri /view/search
     * @param String SearchName Description
     * @return html listnew Description
     * @description view viewSearch   
     */
    public function viewSearch($data);

    /**
     * @name viewSearchsubwelfare
     * @uri /view/searchsub
     * @param String SearchName Description
     * @return html listnew Description
     * @description view viewSearch   
     */
    public function viewSearchsubwelfare($data);
}
