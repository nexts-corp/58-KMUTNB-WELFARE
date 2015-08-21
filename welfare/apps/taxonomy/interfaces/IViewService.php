<?php

namespace apps\taxonomy\interfaces;

/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 */
interface IViewService {

    /**
     * @name lists
     * @uri /main/lists
     * @return html view
     * @description view
     * @authen true
     */
    public function mainLists();

    /**
     * @name add
     * @uri /main/add
     * @return html view
     * @description view
     * @authen true
     */
    public function mainAdd();

    /**
     * @name edit
     * @uri /main/edit
     * @param string code
     * @return html view
     * @description view
     * @authen true
     */
    public function mainEdit($code);
}
