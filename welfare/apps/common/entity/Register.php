<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Register")
     */
class Register {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="registerId") */
       public $registerId;
       
        /**
        *@Column(type="string", length=255, name="titleNameId",nullable=true) 
        */
       public $titleNameId;
       
       /**
        *@Column(type="string", length=255, name="academicPositionsId",nullable=true) 
        */
       public $academicPositionsId;
       
       /**
        *@Column(type="string", length=255, name="rankId",nullable=true) 
        */
       public $rankId;
       
       /**
        *@Column(type="string", length=255, name="registerNameTh",nullable=true) 
        */
       public $registerNameTh;
       
       /**
        *@Column(type="string", length=255, name="registerLastNameTh",nullable=true) 
        */
       public $registerLastNameTh;
       
       /**
        *@Column(type="string", length=255, name="registerNameEn",nullable=true) 
        */
       public $registerNameEn;
       
       /**
        *@Column(type="string", length=255, name="registerLastNameEn",nullable=true) 
        */
       public $registerLastNameEn;
       
       /**
        *@Column(type="string", length=13, name="registerIdCard",nullable=true) 
        */
       public $registerIdCard;
       
       /**
        *@Column(type="string", length=11, name="facultyId",nullable=true) 
        */
       public $facultyId;
       
       /**
        *@Column(type="string", length=255, name="registerPhone",nullable=true) 
        */
       public $registerPhone;
     
        /**
        *@Column(type="string", length=255, name="registerEmail",nullable=true) 
        */
       public $registerEmail;
       
       /**
        *@Column(type="string", length=11, name="departmentId",nullable=true) 
        */
       public $departmentId;
       
       /**
        *@Column(type="string", length=11, name="positionsWorkId",nullable=true) 
        */
       public $positionsWorkId;
       
        /**
        *@Column(type="string", length=11, name="positionsTypeId",nullable=true) 
        */
       public $positionsTypeId;
       
       /**
        *@Column(type="string", length=20, name="registerStaffCode",nullable=true) 
        */
       public $registerStaffCode;
       
       /**
        *@Column(type="string", length=11, name="registerPositionId",nullable=true) 
        */
       public $registerPositionId;
       
       /**
        *@Column(type="string", length=255, name="registerSalaryAdded",nullable=true) 
        */
       public $registerSalaryAdded;
       
       /**
        *@Column(type="string", length=255, name="registerSalaryNow",nullable=true) 
        */
       public $registerSalaryNow;
       
       /**
        *@Column(type="date",  name="registerDateAdded") 
        */
       public $registerDateAdded;
       
        /**
        *@Column(type="date", name="registerDateOfBirth") 
        */
       public $registerDateOfBirth;
       
       /**
        *@Column(type="string", length=255, name="statusOperation",nullable=true) 
        */
       public $statusOperation;
       
       /**
        *@Column(type="string", length=255, name="statusLife",nullable=true) 
        */
       public $statusLife;
       
       /**
        *@Column(type="string",length=255, name="registerAddress",nullable=true) 
        */
       public $registerAddress;
       
       /**
        *@Column(type="string",length=1000, name="registerMobile",nullable=true) 
        */
       public $registerMobile;
       
       /**
        *@Column(type="string", length=30, name="registerOfficePhone",nullable=true) 
        */
       public $registerOfficePhone;
       
       /**
        *@Column(type="string", length=30, name="registerContactPhone",nullable=true) 
        */
       public $registerContactPhone;
      
      /**
        *@Column(type="string",length=30, name="registerIdCardFile",nullable=true) 
        */
       public $registerIdCardFile;
      
      /**
        *@Column(type="string", length=255, name="registerAddressFile",nullable=true) 
        */
      public $registerAddressFile;
      
      /**
        *@Column(type="string",length=255, name="registerBankNumber",nullable=true) 
        */
      public $registerBankNumber;

        /**
        *@Column(type="string",length=255, name="registerBankName",nullable=true) 
        */
      public $registerBankName;
      
      /**
        *@Column(type="string", length=255,name="registerBankAccount",nullable=true) 
        */
      public $registerBankAccount;
      
        /**
        *@Column(type="string",length=255, name="registerBankSk",nullable=true) 
        */
      public $registerBankSk;
      
      public $checkUser;
      
      public $userTypeId;
      
      public $SuperAdminId;
      
            function getRegisterId() {
          return $this->registerId;
      }

      function getTitleNameId() {
          return $this->titleNameId;
      }

      function getAcademicPositionsId() {
          return $this->academicPositionsId;
      }

      function getRankId() {
          return $this->rankId;
      }

      function getRegisterNameTh() {
          return $this->registerNameTh;
      }

      function getRegisterLastNameTh() {
          return $this->registerLastNameTh;
      }

      function getRegisterNameEn() {
          return $this->registerNameEn;
      }

      function getRegisterLastNameEn() {
          return $this->registerLastNameEn;
      }

      function getRegisterIdCard() {
          return $this->registerIdCard;
      }

      function getFacultyId() {
          return $this->facultyId;
      }

      function getRegisterPhone() {
          return $this->registerPhone;
      }

      function getRegisterEmail() {
          return $this->registerEmail;
      }

      function getDepartmentId() {
          return $this->departmentId;
      }

      function getPositionsWorkId() {
          return $this->positionsWorkId;
      }

      function getPositionsTypeId() {
          return $this->positionsTypeId;
      }

      function getRegisterStaffCode() {
          return $this->registerStaffCode;
      }

      function getRegisterPositionId() {
          return $this->registerPositionId;
      }

      function getRegisterSalaryAdded() {
          return $this->registerSalaryAdded;
      }

      function getRegisterSalaryNow() {
          return $this->registerSalaryNow;
      }

      function getRegisterDateAdded() {
          return $this->registerDateAdded;
      }

      function getRegisterDateOfBirth() {
          return $this->registerDateOfBirth;
      }

      function getStatusOperation() {
          return $this->statusOperation;
      }

      function getStatusLife() {
          return $this->statusLife;
      }

      function getRegisterAddress() {
          return $this->registerAddress;
      }

      function getRegisterMobile() {
          return $this->registerMobile;
      }

      function getRegisterOfficePhone() {
          return $this->registerOfficePhone;
      }

      function getRegisterContactPhone() {
          return $this->registerContactPhone;
      }

      function getRegisterIdCardFile() {
          return $this->registerIdCardFile;
      }

      function getRegisterAddressFile() {
          return $this->registerAddressFile;
      }

      function getRegisterBankNumber() {
          return $this->registerBankNumber;
      }

      function getRegisterBankName() {
          return $this->registerBankName;
      }

      function getRegisterBankAccount() {
          return $this->registerBankAccount;
      }

      function getRegisterBankSk() {
          return $this->registerBankSk;
      }

      function setRegisterId($registerId) {
          $this->registerId = $registerId;
      }

      function setTitleNameId($titleNameId) {
          $this->titleNameId = $titleNameId;
      }

      function setAcademicPositionsId($academicPositionsId) {
          $this->academicPositionsId = $academicPositionsId;
      }

      function setRankId($rankId) {
          $this->rankId = $rankId;
      }

      function setRegisterNameTh($registerNameTh) {
          $this->registerNameTh = $registerNameTh;
      }

      function setRegisterLastNameTh($registerLastNameTh) {
          $this->registerLastNameTh = $registerLastNameTh;
      }

      function setRegisterNameEn($registerNameEn) {
          $this->registerNameEn = $registerNameEn;
      }

      function setRegisterLastNameEn($registerLastNameEn) {
          $this->registerLastNameEn = $registerLastNameEn;
      }

      function setRegisterIdCard($registerIdCard) {
          $this->registerIdCard = $registerIdCard;
      }

      function setFacultyId($facultyId) {
          $this->facultyId = $facultyId;
      }

      function setRegisterPhone($registerPhone) {
          $this->registerPhone = $registerPhone;
      }

      function setRegisterEmail($registerEmail) {
          $this->registerEmail = $registerEmail;
      }

      function setDepartmentId($departmentId) {
          $this->departmentId = $departmentId;
      }

      function setPositionsWorkId($positionsWorkId) {
          $this->positionsWorkId = $positionsWorkId;
      }

      function setPositionsTypeId($positionsTypeId) {
          $this->positionsTypeId = $positionsTypeId;
      }

      function setRegisterStaffCode($registerStaffCode) {
          $this->registerStaffCode = $registerStaffCode;
      }

      function setRegisterPositionId($registerPositionId) {
          $this->registerPositionId = $registerPositionId;
      }

      function setRegisterSalaryAdded($registerSalaryAdded) {
          $this->registerSalaryAdded = $registerSalaryAdded;
      }

      function setRegisterSalaryNow($registerSalaryNow) {
          $this->registerSalaryNow = $registerSalaryNow;
      }

      function setRegisterDateAdded($registerDateAdded) {
          $this->registerDateAdded = $registerDateAdded;
      }

      function setRegisterDateOfBirth($registerDateOfBirth) {
          $this->registerDateOfBirth = $registerDateOfBirth;
      }

      function setStatusOperation($statusOperation) {
          $this->statusOperation = $statusOperation;
      }

      function setStatusLife($statusLife) {
          $this->statusLife = $statusLife;
      }

      function setRegisterAddress($registerAddress) {
          $this->registerAddress = $registerAddress;
      }

      function setRegisterMobile($registerMobile) {
          $this->registerMobile = $registerMobile;
      }

      function setRegisterOfficePhone($registerOfficePhone) {
          $this->registerOfficePhone = $registerOfficePhone;
      }

      function setRegisterContactPhone($registerContactPhone) {
          $this->registerContactPhone = $registerContactPhone;
      }

      function setRegisterIdCardFile($registerIdCardFile) {
          $this->registerIdCardFile = $registerIdCardFile;
      }

      function setRegisterAddressFile($registerAddressFile) {
          $this->registerAddressFile = $registerAddressFile;
      }

      function setRegisterBankNumber($registerBankNumber) {
          $this->registerBankNumber = $registerBankNumber;
      }

      function setRegisterBankName($registerBankName) {
          $this->registerBankName = $registerBankName;
      }

      function setRegisterBankAccount($registerBankAccount) {
          $this->registerBankAccount = $registerBankAccount;
      }

      function setRegisterBankSk($registerBankSk) {
          $this->registerBankSk = $registerBankSk;
      }



}
