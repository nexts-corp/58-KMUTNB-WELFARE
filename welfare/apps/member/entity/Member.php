<?php

namespace apps\member\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="Member")
 */
class Member extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="memberId") */
    public $memberId;

    /**
     * @Column(type="string", length=13, name="idCard",nullable=true) 
     */
    public $idCard;

    /**
     * @Column(type="string", length=10, name="genderId",nullable=true) 
     */
    public $genderId;

    /**
     * @Column(type="string", length=10, name="titleNameId",nullable=true) 
     */
    public $titleNameId;

    /**
     * @Column(type="string", length=10, name="academicId",nullable=true) 
     */
    public $academicId;

    /**
     * @Column(type="string", length=255, name="fname",nullable=true) 
     */
    public $fname;

    /**
     * @Column(type="string", length=255, name="lname",nullable=true) 
     */
    public $lname;

    /**
     * @Column(type="date", name="dob") 
     */
    public $dob;

    /**
     * @Column(type="string", length=13, name="employeeCode",nullable=true) 
     */
    public $employeeCode;

    /**
     * @Column(type="string", length=10, name="employeeTypeId",nullable=true) 
     */
    public $employeeTypeId;

    /**
     * @Column(type="string", length=10, name="facultyId",nullable=true) 
     */
    public $facultyId;

    /**
     * @Column(type="string", length=10, name="departmentId",nullable=true) 
     */
    public $departmentId;

    /**
     * @Column(type="string", length=10, name="positionId",nullable=true) 
     */
    public $positionId;

    /**
     * @Column(type="string", length=10, name="matierId",nullable=true) 
     */
    public $matierId;

    /**
     * @Column(type="string", length=255, name="salaryStart",nullable=true) 
     */
    public $salaryStart;

    /**
     * @Column(type="string", length=255, name="salaryPresent",nullable=true) 
     */
    public $salaryPresent;

    /**
     * @Column(type="string", length=255, name="address",nullable=true) 
     */
    public $address;

    /**
     * @Column(type="string", length=255, name="internalPhone",nullable=true) 
     */
    public $internalPhone;

    /**
     * @Column(type="string", length=255, name="phone",nullable=true) 
     */
    public $phone;

    /**
     * @Column(type="string", length=255, name="mobile",nullable=true) 
     */
    public $mobile;

    /**
     * @Column(type="string", length=255, name="email",nullable=true) 
     */
    public $email;

    /**
     * @Column(type="date",  name="workStartDate") 
     */
    public $workStartDate;

    /**
     * @Column(type="date",  name="workEndDate" ,nullable=true) 
     */
    public $workEndDate;

    /**
     * @Column(type="string", length=10, name="memberActiveId",nullable=true) 
     */
    public $memberActiveId;
    public $userTypeId;

    function getMemberId() {
        return $this->memberId;
    }

    function getIdCard() {
        return $this->idCard;
    }

    function getGenderId() {
        return $this->genderId;
    }

    function getTitleNameId() {
        return $this->titleNameId;
    }

    function getAcademicId() {
        return $this->academicId;
    }

    function getFname() {
        return $this->fname;
    }

    function getLname() {
        return $this->lname;
    }

    function getDob() {
        return $this->dob;
    }

    function getEmployeeCode() {
        return $this->employeeCode;
    }

    function getEmployeeTypeId() {
        return $this->employeeTypeId;
    }

    function getFacultyId() {
        return $this->facultyId;
    }

    function getDepartmentId() {
        return $this->departmentId;
    }

    function getPositionId() {
        return $this->positionId;
    }

    function getMatierId() {
        return $this->matierId;
    }

    function getSalaryStart() {
        return $this->salaryStart;
    }

    function getSalaryPresent() {
        return $this->salaryPresent;
    }

    function getAddress() {
        return $this->address;
    }

    function getInternalPhone() {
        return $this->internalPhone;
    }

    function getPhone() {
        return $this->phone;
    }

    function getMobile() {
        return $this->mobile;
    }

    function getEmail() {
        return $this->email;
    }

    function getWorkStartDate() {
        return $this->workStartDate;
    }

    function getWorkEndDate() {
        return $this->workEndDate;
    }

    function getMemberActiveId() {
        return $this->memberActiveId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setIdCard($idCard) {
        $this->idCard = $idCard;
    }

    function setGenderId($genderId) {
        $this->genderId = $genderId;
    }

    function setTitleNameId($titleNameId) {
        $this->titleNameId = $titleNameId;
    }

    function setAcademicId($academicId) {
        $this->academicId = $academicId;
    }

    function setFname($fname) {
        $this->fname = $fname;
    }

    function setLname($lname) {
        $this->lname = $lname;
    }

    function setDob($dob) {
        $this->dob = $dob;
    }

    function setEmployeeCode($employeeCode) {
        $this->employeeCode = $employeeCode;
    }

    function setEmployeeTypeId($employeeTypeId) {
        $this->employeeTypeId = $employeeTypeId;
    }

    function setFacultyId($facultyId) {
        $this->facultyId = $facultyId;
    }

    function setDepartmentId($departmentId) {
        $this->departmentId = $departmentId;
    }

    function setPositionId($positionId) {
        $this->positionId = $positionId;
    }

    function setMatierId($matierId) {
        $this->matierId = $matierId;
    }

    function setSalaryStart($salaryStart) {
        $this->salaryStart = $salaryStart;
    }

    function setSalaryPresent($salaryPresent) {
        $this->salaryPresent = $salaryPresent;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setInternalPhone($internalPhone) {
        $this->internalPhone = $internalPhone;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setWorkStartDate($workStartDate) {
        $this->workStartDate = $workStartDate;
    }

    function setWorkEndDate($workEndDate) {
        $this->workEndDate = $workEndDate;
    }

    function setMemberActiveId($memberActiveId) {
        $this->memberActiveId = $memberActiveId;
    }

}
