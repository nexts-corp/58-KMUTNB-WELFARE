<?php

namespace apps\export\interfaces;

/**
 * @name IExportService
 * @uri /export
 * @description Export เอกสาร
 */
interface IExportService {

    
    
     /**
     * @name getReport
     * @uri /pdf
     * @param string datatable
     * @return string report
     * @description ออกรายงาน pdf
     */
    public function exportPDF($datatable);
}
