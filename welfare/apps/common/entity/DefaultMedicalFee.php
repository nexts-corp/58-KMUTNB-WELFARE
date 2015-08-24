<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="DefaultMedicalFee")
     */
class DefaultMedicalFee {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="defaultMedicalFeeId") */
       public $defaultMedicalFeeId;
       
        /**
        *@Column(type="string" , length=11, name="defaultAmount") 
        */
       public $defaultAmount;
       
       function getDefaultMedicalFeeId() {
           return $this->defaultMedicalFeeId;
       }

       function getDefaultAmount() {
           return $this->defaultAmount;
       }

       function setDefaultMedicalFeeId($defaultMedicalFeeId) {
           $this->defaultMedicalFeeId = $defaultMedicalFeeId;
       }

       function setDefaultAmount($defaultAmount) {
           $this->defaultAmount = $defaultAmount;
       }




}
