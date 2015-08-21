<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Interest")
     */
class Interest {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="interestId") */
       public $interestId;
       
        /**
        *@Column(type="string" , length=255, name="NameInterest") 
        */
       public $NameInterest;
       
       /**
        *@Column(type="string" , length=255, name="LastNameInterest") 
        */
       public $LastNameInterest;
       
       /**
        *@Column(type="string" , length=255, name="RelationStatus") 
        */
       public $RelationStatus;
       
        /**
        *@Column(type="string" , length=255, name="BenefitRatio") 
        */
       public $BenefitRatio;
       
       
       function getInterestId() {
           return $this->interestId;
       }

       function getNameInterest() {
           return $this->NameInterest;
       }

       function getLastNameInterest() {
           return $this->LastNameInterest;
       }

       function getRelationStatus() {
           return $this->RelationStatus;
       }

       function getBenefitRatio() {
           return $this->BenefitRatio;
       }

       function setInterestId($interestId) {
           $this->interestId = $interestId;
       }

       function setNameInterest($NameInterest) {
           $this->NameInterest = $NameInterest;
       }

       function setLastNameInterest($LastNameInterest) {
           $this->LastNameInterest = $LastNameInterest;
       }

       function setRelationStatus($RelationStatus) {
           $this->RelationStatus = $RelationStatus;
       }

       function setBenefitRatio($BenefitRatio) {
           $this->BenefitRatio = $BenefitRatio;
       }



}
