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
    public $contact;
    public $work;
    public $salary;

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

    function getWorkStartDate() {
        return $this->workStartDate;
    }

    function getWorkEndDate() {
        return $this->workEndDate;
    }

    function getMemberActiveId() {
        return $this->memberActiveId;
    }

    function getUserTypeId() {
        return $this->userTypeId;
    }

    function getContact() {
        return $this->contact;
    }

    function getWork() {
        return $this->work;
    }

    function getSalary() {
        return $this->salary;
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

    function setWorkStartDate($workStartDate) {
        $this->workStartDate = $workStartDate;
    }

    function setWorkEndDate($workEndDate) {
        $this->workEndDate = $workEndDate;
    }

    function setMemberActiveId($memberActiveId) {
        $this->memberActiveId = $memberActiveId;
    }

    function setUserTypeId($userTypeId) {
        $this->userTypeId = $userTypeId;
    }

    function setContact($contact) {
        $this->contact = $contact;
    }

    function setWork($work) {
        $this->work = $work;
    }

    function setSalary($salary) {
        $this->salary = $salary;
    }



}
