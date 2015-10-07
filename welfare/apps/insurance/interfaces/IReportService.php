<?php

namespace apps\insurance\interfaces;

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
     * @return html view
     * @description รายการออก report
     */
    public function reportList();
    
    /**
     * @name reportlife
     * @uri /life
     * @return html view
     * @description รายการออก report
     */
    public function reportlife();
}
