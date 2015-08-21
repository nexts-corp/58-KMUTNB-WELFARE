<?php
namespace apps\medical\interfaces;
/**
 * @name medicalfee
 * @uri /report
 * @description จัดการรีพอร์ท
 */
interface IReportMedicalFeeService {
    /**
     * @name viewList
     * @uri /list
     * @return html viewList xxx
     * @description หน้าแสดงรายการรีพอร์ท
     */
    public function viewList();
}
