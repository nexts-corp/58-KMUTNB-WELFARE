<?php
namespace apps\page\interfaces;
/**
 * @name View
 * @uri /view
 * @description แสดง
 */
interface IVewService {
   /**
    * @name dashboardUser
    * @uri /dashboard/user
    * @description แสดงข้อมูลหน้า หลัก ผู้ใช้งานทั่วไป
    */
   public function dashboardUser();
}
