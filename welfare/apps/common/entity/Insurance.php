<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Insurance")
     */
class Insurance {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="insuranceId") */
       public $insuranceId;
       
       /**
        *@Column(type="string",length=255, name="registerIdCard") 
        */
       public $registerIdCard;
       
       /**
        *@Column(type="string",length=255, name="hospitalname") 
        */
       public $hospitalname;
       
       /**
        *@Column(type="date", name="datestart") 
        */
       public $datestart;
       
       /**
        *@Column(type="date", name="dateend") 
        */
       public $dateend;
       
       
       function getInsuranceId() {
           return $this->insuranceId;
       }

       function getRegisterIdCard() {
           return $this->registerIdCard;
       }

       function getHospitalname() {
           return $this->hospitalname;
       }

       function getDatestart() {
           return $this->datestart;
       }

       function getDateend() {
           return $this->dateend;
       }

       function setInsuranceId($insuranceId) {
           $this->insuranceId = $insuranceId;
       }

       function setRegisterIdCard($registerIdCard) {
           $this->registerIdCard = $registerIdCard;
       }

       function setHospitalname($hospitalname) {
           $this->hospitalname = $hospitalname;
       }

       function setDatestart($datestart) {
           $this->datestart = $datestart;
       }

       function setDateend($dateend) {
           $this->dateend = $dateend;
       }



}
