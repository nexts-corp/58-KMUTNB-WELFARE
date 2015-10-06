<?php

namespace apps\retire\interfaces;

/**
 * @name IReportService
 * @uri /reports
 * @description แสดงผล 
 * 
 * @author สิทธิพร
 */
interface IReportService {
    /**
     * @name reportList
     * @uri /lists
     * @return html view
     * @description รายการออก report
     */
    public function reportList();
}
