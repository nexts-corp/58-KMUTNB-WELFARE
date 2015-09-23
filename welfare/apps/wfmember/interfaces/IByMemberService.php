<?php

namespace apps\wfmember\interfaces;

/**
 * @name welfare
 * @uri /bymember
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลสวัสดิการ
 */
interface IByMemberService {

   /**
     * @name preview
     * @uri /history/get
     * @param apps\welfare\entity\History data []
     * @return string history
     * @description test
     */
    public function historyGet($data);
    
}
