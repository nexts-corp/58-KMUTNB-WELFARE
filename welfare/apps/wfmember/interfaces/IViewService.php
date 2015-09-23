<?php
namespace apps\wfmember\interfaces;
/**
 * @name IViewService
 * @uri /view
 * @description แสดงผล 
 * 
 */
interface IViewService {
    
   
    /**
     * @name preview
     * @uri /history/lists
     * @param apps\welfare\entity\History data []
     * @return string history
     * @description test
     */
    public function historyPreview($data);
   
    
    /**
     * @name viewPrivewsList
     * @uri /byMember/lists
     * @return html previews
     * @description แสดงสวัสดิการรายบุคคล
     */
    public function byMemberLists();
    
    /**
     * @name viewMemberWelfarePrivewsList
     * @uri /byMemberWelfare/lists
     * @return html previews
     * @description แสดงรายการสวัสดิการที่พึงจะได้รับ
     */
    public function byMemberWfLists();
    
    
}
