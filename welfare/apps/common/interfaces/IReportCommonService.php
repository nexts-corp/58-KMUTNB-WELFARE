<?php

namespace apps\common\interfaces;

/**
 * @name commonReport
 * @uri /commonReport
 * @description เรียกรายงาน excel pdf
 */
interface IReportCommonService
{


    /**
     * @name rptPdf
     * @uri /rptPdf
     * @param string html
     * @param string filename
     * @param string title
     * @return string file
     * @description รายงาน excel
     */
    public function rptPdf($html, $filename, $title);

}
