<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="SettingMedicalFee")
     */
class SettingMedicalFee {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="SettingMedicalFeeId") */
       public $SettingMedicalFeeId;
       
        /**
        *@Column(type="string" , length=255, name="amountSetting") 
        */
       public $amountSetting;
       
       function getSettingMedicalFeeId() {
           return $this->SettingMedicalFeeId;
       }

       function getAmountSetting() {
           return $this->amountSetting;
       }

       function setSettingMedicalFeeId($SettingMedicalFeeId) {
           $this->SettingMedicalFeeId = $SettingMedicalFeeId;
       }

       function setAmountSetting($amountSetting) {
           $this->amountSetting = $amountSetting;
       }






}
