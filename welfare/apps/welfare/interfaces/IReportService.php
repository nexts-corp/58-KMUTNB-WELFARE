<?php

namespace apps\welfare\interfaces;

/**
 * @name IReportService
 * @uri /reports
 * @description แสดงผล 
 * 
 */
interface IReportService {

    /**
     * @name reportList
     * @uri /lists
     * @param integer detailsId 
     * @return html report
     * @description ออก report ว่า ในสวัสดิการนั้น มีใครที่ได้รับสิทธิ์สวัสดิการบ้าง
     */
 public function reportList($detailsId);
    
  /**
     * @name reportWelfare
     * @uri /lists
     * @param integer memberId 
     * @return html report
     * @description ออก report ว่าสมาชิกใช้ ได้รับสวัสดิการอะไรบ้าง และใช้สวัสดิการอะไร ไปบ้าง
     */
 public function reportWelfare($memberId);
 
}
