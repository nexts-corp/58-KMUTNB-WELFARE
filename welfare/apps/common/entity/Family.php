<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Family")
     */
class Family {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="familyId") */
       public $familyId;
       
        /**
        *@Column(type="integer" , length=13, name="registerId",nullable=true) 
        */
       public $registerId;
       
        /**
        *@Column(type="string" , length=255, name="familyName",nullable=true) 
        */
       public $familyName;
       
        /**
        *@Column(type="string" , length=255, name="familyLastName",nullable=true) 
        */
       public $familyLastName;
       
        /**
        *@Column(type="string" , length=13, name="idCard",nullable=true) 
        */
       public $idCard;
       
       /**
        *@Column(type="string" , length=255, name="familyAddress",nullable=true) 
        */
       public $familyAddress;
       
       /**
        *@Column(type="string" , length=255, name="familyTelephone",nullable=true) 
        */
       public $familyTelephone;
       
       /**
        *@Column(type="string" , name="familyBirthday",nullable=true) 
        */
       public $familyBirthday;
       
       /**
        *@Column(type="string" , length=255, name="familyStatusReraTion",nullable=true) 
        */
       public $familyStatusReraTion;
       
        /**
        *@Column(type="string", length=255, name="rankId",nullable=true) 
        */
       public $rankId;
       
        /**
        *@Column(type="string", length=255, name="titleNameId",nullable=true) 
        */
       public $titleNameId;
       
       /**
        *@Column(type="string", length=255, name="academicPositionsId",nullable=true) 
        */
       public $academicPositionsId;
        
       /**
        *@Column(type="string", length=255, name="familyContactPhone",nullable=true) 
        */
       public $familyContactPhone;
     
        /**
        *@Column(type="string", length=255, name="familyEmail",nullable=true) 
        */
       public $familyEmail;
         /**
        *@Column(type="string", length=255, name="familyMobile",nullable=true) 
        */
       public $familyMobile;
       function getFamilyId() {
           return $this->familyId;
       }

       function getRegisterId() {
           return $this->registerId;
       }

       function getFamilyName() {
           return $this->familyName;
       }

       function getFamilyLastName() {
           return $this->familyLastName;
       }

       function getIdCard() {
           return $this->idCard;
       }

       function getFamilyAddress() {
           return $this->familyAddress;
       }

       function getFamilyTelephone() {
           return $this->familyTelephone;
       }

       function getFamilyBirthday() {
           return $this->familyBirthday;
       }

       function getFamilyStatusReraTion() {
           return $this->familyStatusReraTion;
       }

       function getRankId() {
           return $this->rankId;
       }

       function getTitleNameId() {
           return $this->titleNameId;
       }

       function getAcademicPositionsId() {
           return $this->academicPositionsId;
       }

       function getFamilyContactPhone() {
           return $this->familyContactPhone;
       }

       function getFamilyEmail() {
           return $this->familyEmail;
       }

       function getFamilyMobile() {
           return $this->familyMobile;
       }

       function setFamilyId($familyId) {
           $this->familyId = $familyId;
       }

       function setRegisterId($registerId) {
           $this->registerId = $registerId;
       }

       function setFamilyName($familyName) {
           $this->familyName = $familyName;
       }

       function setFamilyLastName($familyLastName) {
           $this->familyLastName = $familyLastName;
       }

       function setIdCard($idCard) {
           $this->idCard = $idCard;
       }

       function setFamilyAddress($familyAddress) {
           $this->familyAddress = $familyAddress;
       }

       function setFamilyTelephone($familyTelephone) {
           $this->familyTelephone = $familyTelephone;
       }

       function setFamilyBirthday($familyBirthday) {
           $this->familyBirthday = $familyBirthday;
       }

       function setFamilyStatusReraTion($familyStatusReraTion) {
           $this->familyStatusReraTion = $familyStatusReraTion;
       }

       function setRankId($rankId) {
           $this->rankId = $rankId;
       }

       function setTitleNameId($titleNameId) {
           $this->titleNameId = $titleNameId;
       }

       function setAcademicPositionsId($academicPositionsId) {
           $this->academicPositionsId = $academicPositionsId;
       }

       function setFamilyContactPhone($familyContactPhone) {
           $this->familyContactPhone = $familyContactPhone;
       }

       function setFamilyEmail($familyEmail) {
           $this->familyEmail = $familyEmail;
       }

       function setFamilyMobile($familyMobile) {
           $this->familyMobile = $familyMobile;
       }


}
