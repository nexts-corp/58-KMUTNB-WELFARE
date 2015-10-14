<?php
namespace apps\page\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\page\interfaces\IVewService;
/**
 * Description of ViewService
 *
 * @author สิทธิพร
 */
class ViewService extends CServiceBase implements IVewService{
    //put your code here
    public $datacontext;
    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function dashboardUser() {
        $view = new CJView("user/lists", CJViewType::HTML_VIEW_ENGINE);
        
        $path = "apps\\news\\entity\\";
        $pathMember = "apps\\member\\entity\\";

        $memberId = $this->getCurrentUser()->code;

        $sqlMember = "SELECT mb.memberId, mb.employeeTypeId "
                . " From " . $pathMember . "Work mb where mb.memberId =:memberId ";
        $paramMember = array("memberId" => $memberId);

        $objMember = $this->datacontext->getObject($sqlMember, $paramMember)[0];
        $employeeType = $objMember["employeeTypeId"];


        $sqlNews = "SELECT nw.newsName,nw.newsId ,nw.employeeTypeId,nw.dateCreated,nw.newsDetails "
                . " From " . $path . "News nw Where nw.employeeTypeId LIKE '%" . $employeeType . "%' Order By nw.newsId DESC ";
        $objNews = $this->datacontext->getObject($sqlNews);


        foreach ($objNews as $key => $value) {
            $objNews[$key]["dateCreated"] = $value["dateCreated"]->format('d-m-Y');
            $objNews[$key]["newsDetails"] = strip_tags($value["newsDetails"]);
        }
        $i = 1;
        if ($objNews != "") {
            foreach ($objNews as $key => $value) {

                $objNews[$key]["rowNo"] = $i++;
            }

            $view->datasNews = $objNews;
        }
        
        $memberId = $this->getCurrentUser()->code;
        $view->memberId = $memberId;
        return $view;
    }

}
