<?php

namespace apps\member\interfaces;

/**
 * @name member
 * @uri /member
 * @return html member Description
 * @description จัดการบุคคลากร
 */
interface IMemberService {


    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Register data []
     * @return boolean save [return ture or false if don't ]
     * @description save data to database
     */
    public function save($data);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Register data []
     * @return boolean update Description
     * @description view list new
     */
    public function update($data);

    /**
     * @name viewSearch
     * @uri /search
     * @param String SearchName Description
     * @return html listnew Description
     * @description view viewSearch   
    */
    public function viewSearch($data);
}
