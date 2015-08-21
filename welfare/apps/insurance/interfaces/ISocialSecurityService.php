<?php
namespace apps\insurance\interfaces;
/**
 * @name socialsecurity
 * @uri /social/security
 * @description จัดการข้อมูลประกันสังคม
 */
interface ISocialSecurityService {
    
    /**
     * @name viewList
     * @uri /list
     * @return html viewList xxx
     * @description หน้าแสดงรายการจัดการข้อมูลประกันสังคม
     */
    public function viewList();
    
           /**
     * @name save
     * @uri /save
     * @param apps/common/entity/SocialSecurity data []
     * @return boolean save []
     * @description บันทึกข้อมูลผู้รับผลประโยชน์
     */
    public function save($data);

    /**
     * @name update
     * @uri /update
     * @param apps/common/entity/SocialSecurity data []
     * @return boolean update []
     * @description อัพเดทข้อมูลผู้รับผลประโยชน์
     */
    public function update($data);

    /**
     * @name delete
     * @uri /delete
     * @param apps/common/entity/SocialSecurity data []
     * @return boolean delete []
     * @description ลบข้อมูลผู้รับผลประโยชน์
     */
    public function delete($data);
}
