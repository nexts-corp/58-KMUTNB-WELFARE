<?php
namespace apps\ManagementFund\interfaces;
/**
 * @name fund
 * @uri /fund
 * @description จัดการข้อมูลกองทุน
 */
interface IFundService {
    /**
     * @name viewList
     * @uri /list
     * @return html viewList xxx
     * @description หน้าแสดงรายการจัดการสมาชิก
     */
    public function viewList();
}
