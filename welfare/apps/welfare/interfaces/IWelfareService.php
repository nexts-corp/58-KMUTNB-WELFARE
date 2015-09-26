<?php

namespace apps\welfare\interfaces;

/**
 * @name IWelfareService
 * @uri /welfare
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ข้อมูลสวัสดิการ
 */
interface IWelfareService {

    /**
     * @name save
     * @uri /save
     * @param apps\welfare\entity\Welfare welfare []
     * @return boolean save [return ture or false if don't ]
     * @description save เพิ่มข้อมูลสวัสดิการ
     */
    public function save($welfare);

    /**
     * @name updatewelfare
     * @uri /update
     * @param apps\welfare\entity\Welfare data []
     * @return boolean update [return ture or false if don't ]
     * @description update แก้ไขข้อมูลสวัสดิการ
     */
    public function update($datas);

    /**
     * @name deletewelfare
     * @uri /delete
     * @param integer Id Description
     * @return boolean delete [return ture or false if don't ]
     * @description delete ลบข้อมูลสวัสดิการ
     */
    public function delete($Id);

    /**
     * @name get
     * @uri /get
     * @param string welfareId
     * @return string welfare
     * @description getลิสต์ข้อมูล
     */
    public function get($welfareId);
}
