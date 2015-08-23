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
     * @uri /parent/lists
     * @return html view
     * @description view
     * @authen true
     */
    public function parentLists();

    /**
     * @name add
     * @uri /parent/add
     * @return html view
     * @description view
     * @authen true
     */
    public function parentAdd();

    /**
     * @name edit
     * @uri /parent/edit
     * @param string code
     * @return html view
     * @description view
     * @authen true
     */
    public function parentEdit($code);
    
       /**
     * @name lists
     * @uri /child/lists
     * @return html view
     * @description view
     * @authen true
     */
    public function childLists();
    
     

    /**
     * @name add
     * @uri /child/add
     * @return html view
     * @description view
     * @authen true
     */
    public function childAdd();

    /**
     * @name edit
     * @uri /child/edit
     * @param string code
     * @return html view
     * @description view
     * @authen true
     */
    public function childEdit($code);

}
