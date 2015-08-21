<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="WelfareConditions")
     */
class WelfareConditions {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="welfareConditionsId") */
       public $welfareConditionsId;
       
        /**
        *@Column(type="string", name="welfareSubId") 
        */
       public $welfareSubId;
       
        /**
        *@Column(type="string", name="positionsTypeId") 
        */
       public $positionsTypeId;
       
       
       /**
        *@Column(type="date", name="dateStartWorking") 
        */
       public $dateStartWorking;
       
       /**
        *@Column(type="date", name="dateEndWork") 
        */
       public $dateEndWork;
       
       /**
        *@Column(type="integer", length=3, name="ageWorkLess") 
        */
       public $ageWorkLess;
       
       /**
        *@Column(type="integer", length=3, name="ageWorkMore") 
        */
       public $ageWorkMore;
       
       /**
        *@Column(type="integer", length=3, name="ageWorkAs") 
        */
       public $ageWorkAs;
       
       /**
        *@Column(type="integer", length=3, name="ageWorkSince") 
        */
       public $ageWorkSince;
       
       /**
        *@Column(type="integer", length=3, name="ageWorkTo") 
        */
       public $ageWorkTo;
       
       /**
        *@Column(type="integer", length=3, name="ageLess") 
        */
       public $ageLess;
       
       /**
        *@Column(type="integer", length=3, name="ageMore") 
        */
       public $ageMore;
       
       /**
        *@Column(type="integer", length=3, name="ageAs") 
        */
       public $ageAs;
       
       /**
        *@Column(type="integer", length=3, name="ageSince") 
        */
       public $ageSince;
       
       /**
        *@Column(type="integer", length=3, name="ageTo") 
        */
       public $ageTo;
       
       /**
        *@Column(type="string",length=1, name="statusVoluntary") 
        */
       public $statusVoluntary;
       
        /**
        *@Column(type="string", length=1, name="statusRetired" ) 
        */
       public $statusRetired;
       
       function getWelfareConditionsId() {
           return $this->welfareConditionsId;
       }

       function getWelfareSubId() {
           return $this->welfareSubId;
       }

       function getDateStartWorking() {
           return $this->dateStartWorking;
       }

       function getDateEndWork() {
           return $this->dateEndWork;
       }

       function getAgeWorkLess() {
           return $this->ageWorkLess;
       }

       function getAgeWorkMore() {
           return $this->ageWorkMore;
       }

       function getAgeWorkAs() {
           return $this->ageWorkAs;
       }

       function getAgeWorkSince() {
           return $this->ageWorkSince;
       }

       function getAgeWorkTo() {
           return $this->ageWorkTo;
       }

       function getAgeLess() {
           return $this->ageLess;
       }

       function getAgeMore() {
           return $this->ageMore;
       }

       function getAgeAs() {
           return $this->ageAs;
       }

       function getAgeSince() {
           return $this->ageSince;
       }

       function getAgeTo() {
           return $this->ageTo;
       }

       function getStatusVoluntary() {
           return $this->statusVoluntary;
       }

       function getStatusRetired() {
           return $this->statusRetired;
       }

       function setWelfareConditionsId($welfareConditionsId) {
           $this->welfareConditionsId = $welfareConditionsId;
       }

       function setWelfareSubId($welfareSubId) {
           $this->welfareSubId = $welfareSubId;
       }

       function setDateStartWorking($dateStartWorking) {
           $this->dateStartWorking = $dateStartWorking;
       }

       function setDateEndWork($dateEndWork) {
           $this->dateEndWork = $dateEndWork;
       }

       function setAgeWorkLess($ageWorkLess) {
           $this->ageWorkLess = $ageWorkLess;
       }

       function setAgeWorkMore($ageWorkMore) {
           $this->ageWorkMore = $ageWorkMore;
       }

       function setAgeWorkAs($ageWorkAs) {
           $this->ageWorkAs = $ageWorkAs;
       }

       function setAgeWorkSince($ageWorkSince) {
           $this->ageWorkSince = $ageWorkSince;
       }

       function setAgeWorkTo($ageWorkTo) {
           $this->ageWorkTo = $ageWorkTo;
       }

       function setAgeLess($ageLess) {
           $this->ageLess = $ageLess;
       }

       function setAgeMore($ageMore) {
           $this->ageMore = $ageMore;
       }

       function setAgeAs($ageAs) {
           $this->ageAs = $ageAs;
       }

       function setAgeSince($ageSince) {
           $this->ageSince = $ageSince;
       }

       function setAgeTo($ageTo) {
           $this->ageTo = $ageTo;
       }

       function setStatusVoluntary($statusVoluntary) {
           $this->statusVoluntary = $statusVoluntary;
       }

       function setStatusRetired($statusRetired) {
           $this->statusRetired = $statusRetired;
       }

       

       function isStatusVoluntary(){
      
           if($this->statusVoluntary=="Y"){
               return "checked";
           }
           else{
               return "";
           }
       }
       
       function isStatusRetired(){
      
           if($this->statusRetired=="Y"){
               return "checked";
           }
           else{
               return "";
           }
       }


       
       
       
}
