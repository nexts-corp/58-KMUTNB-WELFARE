<?php
namespace apps\welfare\entity;
/**
     * @Entity
     * @Table(name="Condition")
     */
class Condition {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="conditionId") */
       public $conditionId;
       
        /**
        *@Column(type="integer", name="welfareId") 
        */
       public $welfareId;
       
        /**
        *@Column(type="string", name="conditionName") 
        */
       public $conditionName;
       
       
       /**
        *@Column(type="date", name="dateStartWork") 
        */
       public $dateStartWork;
       
       /**
        *@Column(type="date", name="dateEndWork") 
        */
       public $dateEndWork;
       
       /**
        *@Column(type="integer", length=3, name="ageWorkStart") 
        */
       public $ageWorkStart;
       
       /**
        *@Column(type="integer", length=3, name="ageWorkEnd") 
        */
       public $ageWorkEnd;
       
       
       
       /**
        *@Column(type="integer", length=3, name="ageStart") 
        */
       public $ageStart;
       
       /**
        *@Column(type="integer", length=3, name="ageEnd") 
        */
       public $ageEnd;
       
       
       
       /**
        *@Column(type="string",length=1, name="employeeTypeId") 
        */
       public $employeeTypeId;
       
        /**
        *@Column(type="string", length=1, name="amount" ) 
        */
       public $amount;
       
       /**
        *@Column(type="string", length=1, name="returnType" ) 
        */
       public $returnType;
       
       /**
        *@Column(type="date", name="resetTime" ) 
        */
       public $resetTime;
       
      

       
       function getConditionId() {
           return $this->conditionId;
       }

       function getWelfareId() {
           return $this->welfareId;
       }

       function getDescription() {
           return $this->description;
       }

       function getDateStartWork() {
           return $this->dateStartWork;
       }

       function getDateEndWork() {
           return $this->dateEndWork;
       }

       function getAgeWorkStart() {
           return $this->ageWorkStart;
       }

       function getAgeWorkEnd() {
           return $this->ageWorkEnd;
       }

       function getAgeStart() {
           return $this->ageStart;
       }

       function getAgeEnd() {
           return $this->ageEnd;
       }

       function getEmployeeTypeId() {
           return $this->employeeTypeId;
       }

       function getAmount() {
           return $this->amount;
       }

       function getReturnType() {
           return $this->returnType;
       }

       function getResetTime() {
           return $this->resetTime;
       }

       function setConditionId($conditionId) {
           $this->conditionId = $conditionId;
       }

       function setWelfareId($welfareId) {
           $this->welfareId = $welfareId;
       }

       function setDescription($description) {
           $this->description = $description;
       }

       function setDateStartWork($dateStartWork) {
           $this->dateStartWork = $dateStartWork;
       }

       function setDateEndWork($dateEndWork) {
           $this->dateEndWork = $dateEndWork;
       }

       function setAgeWorkStart($ageWorkStart) {
           $this->ageWorkStart = $ageWorkStart;
       }

       function setAgeWorkEnd($ageWorkEnd) {
           $this->ageWorkEnd = $ageWorkEnd;
       }

       function setAgeStart($ageStart) {
           $this->ageStart = $ageStart;
       }

       function setAgeEnd($ageEnd) {
           $this->ageEnd = $ageEnd;
       }

       function setEmployeeTypeId($employeeTypeId) {
           $this->employeeTypeId = $employeeTypeId;
       }

       function setAmount($amount) {
           $this->amount = $amount;
       }

       function setReturnType($returnType) {
           $this->returnType = $returnType;
       }

       function setResetTime($resetTime) {
           $this->resetTime = $resetTime;
       }



//       function isStatusVoluntary(){
//      
//           if($this->statusVoluntary=="Y"){
//               return "checked";
//           }
//           else{
//               return "";
//           }
//       }
//       
//       function isStatusRetired(){
//      
//           if($this->statusRetired=="Y"){
//               return "checked";
//           }
//           else{
//               return "";
//           }
//       }


       
       
       
}
