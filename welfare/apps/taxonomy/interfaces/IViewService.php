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
     * @uri /lists
     * @return html view
     * @description view
     * @authen true
     */
    public function lists();
    
     

    /**
     * @name add
     * @uri /add
     * @return html view
     * @description view
     * @authen true
     */
    public function add();

    /**
     * @name edit
     * @uri /edit
     * @param string id
     * @return html view
     * @description view
     * @authen true
     */
    public function edit($id);

}
