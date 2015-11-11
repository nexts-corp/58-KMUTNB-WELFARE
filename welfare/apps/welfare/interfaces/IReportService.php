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
     * @name reportApprove
     * @uri /approve
     * @return html report
     * @description ออก report csv ว่า อนุมัติสวัสดิการอะไรไปแล้วบ้าง
     */
 public function reportApprove();
 
}
