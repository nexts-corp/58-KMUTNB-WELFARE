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
     * @Column(type="string", length=13, name="idCard",nullable=true) 
     */
    public $idCard;

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
     * @Column(type="string", length=10, name="employeeId",nullable=true) 
     */
    public $employeeId;

    /**
     * @Column(type="string", length=10, name="divisionId",nullable=true) 
     */
    public $divisionId;

    /**
     * @Column(type="string", length=10, name="departmentId",nullable=true) 
     */
    public $departmentId;

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
     * @Column(type="string", length=13, name="employeeCode",nullable=true) 
     */
    public $employeeCode;

    /**
     * @Column(type="string", length=10, name="positionId",nullable=true) 
     */
    public $positionId;

    /**
     * @Column(type="string", length=10, name="titleId",nullable=true) 
     */
    public $titleId;

    /**
     * @Column(type="string", length=10, name="lineId",nullable=true) 
     */
    public $lineId;

    /**
     * @Column(type="date",  name="workStartDate") 
     */
    public $workStartDate;

    /**
     * @Column(type="string", length=10, name="academicId",nullable=true) 
     */
    public $academicId;

    function getMemberId() {
        return $this->memberId;
    }

    function getIdCard() {
        return $this->idCard;
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

    function getEmployeeId() {
        return $this->employeeId;
    }

    function getDivisionId() {
        return $this->divisionId;
    }

    function getDepartmentId() {
        return $this->departmentId;
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

    function getEmployeeCode() {
        return $this->employeeCode;
    }

    function getPositionId() {
        return $this->positionId;
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

    function setFname($fname) {
        $this->fname = $fname;
    }

    function setLname($lname) {
        $this->lname = $lname;
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

    function setDepartmentId($departmentId) {
        $this->departmentId = $departmentId;
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

    function setEmployeeCode($employeeCode) {
        $this->employeeCode = $employeeCode;
    }

    function setPositionId($positionId) {
        $this->positionId = $positionId;
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
