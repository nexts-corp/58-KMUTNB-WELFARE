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
 
 /**
     * @name reportRight
     * @uri /right
     * @return html lists
     * @description ออก report ว่าบุคคลท่านนี้ได้รับสวัสดิการอะไรบ้าง ใช้อะไรไปแล้วบ้าง 
     */
 public function reportRight();
 
 /**
     * @name reportCsvWelfare
     * @uri /csv/welfare
     * @return string lists
     * @description ออก csv ว่าสวัสดิการนี้ ใช้ไปเท่าไร ใครใช้บ้าง
     */
 public function reportCsvWelfare();


 /**
  * @name reportIndividualList
  * @uri /report/Individual
  * @param string data
  * @return file lists
  * @description เมนู สวัสดิการรายบุคคล
  */
 public function reportIndividualList($data);
 
}
