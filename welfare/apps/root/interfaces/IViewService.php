<?php
namespace apps\root\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {
   
    /**
     * @name index
     * @uri /index
     * @description  index
     * @authen true
     */ 
    public function index();

    /**
     * @name logout
     * @uri /logout
     * @description  logout
     */ 
    public function logout();
}
