<?php

namespace apps\welfare\interfaces;

/**
 * @name welfare
 * @uri /welfareclaims
 * @description จัดการ การขอรับสวัสดิการ
 */
interface IWelfareClaimsService {

    /**
     * @name add
     * @uri /add
     * @param Int registerId Description
     * @param Int welfareId Description
     * @return html add Description
     * @description ขอรับสวัสดิการแต่ละบุคคล
     */
    public function add($registerId, $welfareId);

    /**
     * @name approve
     * @uri /approve
     * @param Int welfareRightsId Description
     * @return html approve Description
     * @description แสดงสวัสดิการแต่ละบุคคล
     */
    public function approve($welfareRightsId);

    /**
     * @name unapproved
     * @uri /unapproved
     * @param Int welfareRightsId Description
     * @return html unapproved Description
     * @description แสดงสวัสดิการแต่ละบุคคล
     */
    public function unapproved($welfareRightsId);
}
