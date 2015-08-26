<?php
namespace apps\member\entity;
/**
     * @Entity
     * @Table(name="Member")
     */
class Member {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="memberId") */
       public $memberId;
       
       /**
        *@Column(type="string", length=13, name="idCard",nullable=true) 
        */
       public $idCard;
       
       /**
        *@Column(type="string", length=255, name="fNameTh",nullable=true) 
        */
       public $fNameTh;
       
       /**
        *@Column(type="string", length=255, name="lNameTh",nullable=true) 
        */
       public $lNameTh;
       
       /**
        *@Column(type="string", length=255, name="fNameEn",nullable=true) 
        */
       public $fNameEn;
       
       /**
        *@Column(type="string", length=255, name="lNameEn",nullable=true) 
        */
       public $lNameEn;
       
       /**
        *@Column(type="date", name="dob") 
        */
       public $dob;
       
       /**
        *@Column(type="integer", length=11, name="employeeId",nullable=true) 
        */
       public $employeeId;
       
       /**
        *@Column(type="string", length=11, name="divisionId",nullable=true) 
        */
       public $divisionId;
       
       /**
        *@Column(type="string", length=11, name="departmentId",nullable=true) 
        */
       public $departmentId;
       
       /**
        *@Column(type="string", length=255, name="internalphone",nullable=true) 
        */
       public $internalphone;
       
       /**
        *@Column(type="string", length=255, name="phone",nullable=true) 
        */
       public $phone;
       
       /**
        *@Column(type="string", length=255, name="mobile",nullable=true) 
        */
       public $mobile;
       
       /**
        *@Column(type="string", length=255, name="employeeCode",nullable=true) 
        */
       public $employeeCode;
       
       /**
        *@Column(type="integer", length=11, name="positionbId",nullable=true) 
        */
       public $positionbId;
       
       /**
        *@Column(type="integer", length=11, name="titleId",nullable=true) 
        */
       public $titleId;
       
        /**
        *@Column(type="integer", length=11, name="lineId",nullable=true) 
        */
       public $lineId;
       
       /**
        *@Column(type="date",  name="workStartDate") 
        */
       public $workStartDate;
       
       /**
        *@Column(type="integer", length=11, name="academicId",nullable=true) 
        */
       public $academicId;
       
       function getMemberId() {
           return $this->memberId;
       }

       function getIdCard() {
           return $this->idCard;
       }

       function getFNameTh() {
           return $this->fNameTh;
       }

       function getLNameTh() {
           return $this->lNameTh;
       }

       function getFNameEn() {
           return $this->fNameEn;
       }

       function getLNameEn() {
           return $this->lNameEn;
       }

       function getDob() {
           return $this->dob;
       }

       function getEmployeeId() {
           return $this->employeeId;
       }

       function getDivisionId() {
           return $this->divisionId;
       }

       function getInternalphone() {
           return $this->internalphone;
       }

       function getPhone() {
           return $this->phone;
       }

       function getMobile() {
           return $this->mobile;
       }

       function getEmployeeCode() {
           return $this->employeeCode;
       }

       function getPositionbId() {
           return $this->positionbId;
       }

       function getTitleId() {
           return $this->titleId;
       }

       function getLineId() {
           return $this->lineId;
       }

       function getWorkStartDate() {
           return $this->workStartDate;
       }

       function getAcademicId() {
           return $this->academicId;
       }

       function setMemberId($memberId) {
           $this->memberId = $memberId;
       }

       function setIdCard($idCard) {
           $this->idCard = $idCard;
       }

       function setFNameTh($fNameTh) {
           $this->fNameTh = $fNameTh;
       }

       function setLNameTh($lNameTh) {
           $this->lNameTh = $lNameTh;
       }

       function setFNameEn($fNameEn) {
           $this->fNameEn = $fNameEn;
       }

       function setLNameEn($lNameEn) {
           $this->lNameEn = $lNameEn;
       }

       function setDob($dob) {
           $this->dob = $dob;
       }

       function setEmployeeId($employeeId) {
           $this->employeeId = $employeeId;
       }

       function setDivisionId($divisionId) {
           $this->divisionId = $divisionId;
       }

       function setInternalphone($internalphone) {
           $this->internalphone = $internalphone;
       }

       function setPhone($phone) {
           $this->phone = $phone;
       }

       function setMobile($mobile) {
           $this->mobile = $mobile;
       }

       function setEmployeeCode($employeeCode) {
           $this->employeeCode = $employeeCode;
       }

       function setPositionbId($positionbId) {
           $this->positionbId = $positionbId;
       }

       function setTitleId($titleId) {
           $this->titleId = $titleId;
       }

       function setLineId($lineId) {
           $this->lineId = $lineId;
       }

       function setWorkStartDate($workStartDate) {
           $this->workStartDate = $workStartDate;
       }

       function setAcademicId($academicId) {
           $this->academicId = $academicId;
       }


       


       
       
       
       
}
