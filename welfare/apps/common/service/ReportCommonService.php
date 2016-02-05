<?php

namespace apps\common\service;

use apps\common\interfaces\IReportCommonService;
use mPDF;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;


class ReportCommonService extends CServiceBase implements IReportCommonService
{

    public $datacontext;

    function __construct()
    {
        $this->datacontext = new CDataContext();
    }


    public function rptPdf($html, $filename, $title)
    {
        // TODO: Implement rptExcel() method.

        $mpdf = new mPdf('th', 'A4', '0', 'garuda');// garuda for ThaiSaraban
        $mpdf->SetAutoFont();
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->h2toc = array('H3' => 0, 'H4' => 1);
        $mpdf->h2bookmarks = array('H3' => 0, 'H4' => 1);
        $mpdf->open_layer_pane = false;
        $mpdf->layerDetails[1]['state'] = 'hidden';    // Set initial state of layer - "hidden" or nothing
        $mpdf->layerDetails[1]['name'] = 'Correct Answers';
        $mpdf->layerDetails[2]['state'] = 'hidden';    // Set initial state of layer - "hidden" or nothing
        $mpdf->layerDetails[2]['name'] = 'Wrong Answers';

        $mpdf->setFooter("DatePrint :  " . date("d/m/Y") . "   Page {PAGENO} of {nb}");
        //==============================================================
        $mpdf->autoLangToFont = true;
        $datas = '<style> table { border-collapse: collapse }';
        $datas .= '       table, th, td { border: 1px solid black; } </style>';
        $datas .= '<h3>' . $title . '</h3>';
        $datas .= "<table>";
        $datas .= $html;
        $datas .= "</table>";
        $mpdf->WriteHTML($datas);
        // OUTPUT
        $mpdf->Output($filename . ".pdf", "F");

        return $filename . ".pdf";
    }


    public function t()
    {
        return "pdf";
    }
}
