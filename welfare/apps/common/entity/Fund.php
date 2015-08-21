<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Fund")
     */
class Fund {
     /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="fundId") */
       public $fundId;
       
        /**
        *@Column(type="integer" , length=20, name="staffTypeId") 
        */
       public $staffTypeId;
       
        /**
        *@Column(type="string" , length=255, name="registerId") 
        */
       public $registerId;
       
       /**
        *@Column(type="string" , length=255, name="fundName") 
        */
       public $fundName;
       
       /**
        *@Column(type="string" , length=255, name="fundStatusPrefer") 
        */
       public $fundStatusPrefer;
       
       /**
        *@Column(type="string" , length=255, name="fundDetailsInvest") 
        */
       public $fundDetailsInvest;
       
       
       function getFundId() {
           return $this->fundId;
       }

       function getStaffTypeId() {
           return $this->staffTypeId;
       }

       function getRegisterId() {
           return $this->registerId;
       }

       function getFundName() {
           return $this->fundName;
       }

       function getFundStatusPrefer() {
           return $this->fundStatusPrefer;
       }

       function getFundDetailsInvest() {
           return $this->fundDetailsInvest;
       }

       function setFundId($fundId) {
           $this->fundId = $fundId;
       }

       function setStaffTypeId($staffTypeId) {
           $this->staffTypeId = $staffTypeId;
       }

       function setRegisterId($registerId) {
           $this->registerId = $registerId;
       }

       function setFundName($fundName) {
           $this->fundName = $fundName;
       }

       function setFundStatusPrefer($fundStatusPrefer) {
           $this->fundStatusPrefer = $fundStatusPrefer;
       }

       function setFundDetailsInvest($fundDetailsInvest) {
           $this->fundDetailsInvest = $fundDetailsInvest;
       }





}
