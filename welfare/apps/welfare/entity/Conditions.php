<?php

namespace apps\welfare\entity;

/**
 * @Entity
 * @Table(name="WelfareConditions")
 */
class Conditions {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="conditionsId") */
    public $conditionsId;

    /**
     * @Column(type="integer",length=11, name="welfareId")
     */
    public $welfareId;

    /**
     * @Column(type="string", name="description",nullable=true)
     */
    public $description;

    /**
     * @Column(type="string", length=10, name="amount" ) 
     */
    public $amount;

    /**
     * @Column(type="string", length=10, name="returnTypeId",nullable=true)
     */
    public $returnTypeId; //หน่วยนับ

    /**
     * @Column(type="date", name="dateStartWork",nullable=true)
     */
    public $dateStartWork; //วันที่บรรจุ

    /**
     * @Column(type="date", name="dateEndWork",nullable=true)
     */
    public $dateEndWork; //วันที่เกษียณ

    /**
     * @Column(type="integer", length=3, name="ageStart",nullable=true)
     */
    public $ageStart; //อายุตั้งแต่

    /**
     * @Column(type="integer", length=3, name="ageEnd",nullable=true)
     */
    public $ageEnd; //อายุถึง

    /**
     * @Column(type="integer", length=3, name="ageWorkStart",nullable=true)
     */
    public $ageWorkStart; //อายุการปฎิบัติงานตั้งแต่

    /**
     * @Column(type="integer", length=3, name="ageWorkEnd",nullable=true)
     */
    public $ageWorkEnd; //อายุการปฎิบัติงานถึง

    /**
     * @Column(type="string", length=13, name="genderId",nullable=true)
     */
    public $genderId; //เพศ

    /**
     * @Column(type="string", length=10, name="employeeTypeId",nullable=true)
     */
    public $employeeTypeId; //พนักงาน

    function getConditionsId() {
        return $this->conditionsId;
    }

    function getWelfareId() {
        return $this->welfareId;
    }

    function getDescription() {
        return $this->description;
    }

    function getAmount() {
        return $this->amount;
    }

    function getDateStartWork() {
        return $this->dateStartWork;
    }

    function getDateEndWork() {
        return $this->dateEndWork;
    }

    function getAgeStart() {
        return $this->ageStart;
    }

    function getAgeEnd() {
        return $this->ageEnd;
    }

    function getAgeWorkStart() {
        return $this->ageWorkStart;
    }

    function getAgeWorkEnd() {
        return $this->ageWorkEnd;
    }

    function getGenderId() {
        return $this->genderId;
    }

    function getEmployeeTypeId() {
        return $this->employeeTypeId;
    }

    function getReturnTypeId() {
        return $this->returnTypeId;
    }

    function setConditionsId($conditionsId) {
        $this->conditionsId = $conditionsId;
    }

    function setWelfareId($welfareId) {
        $this->welfareId = $welfareId;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setDateStartWork($dateStartWork) {
        $this->dateStartWork = $dateStartWork;
    }

    function setDateEndWork($dateEndWork) {
        $this->dateEndWork = $dateEndWork;
    }

    function setAgeStart($ageStart) {
        $this->ageStart = $ageStart;
    }

    function setAgeEnd($ageEnd) {
        $this->ageEnd = $ageEnd;
    }

    function setAgeWorkStart($ageWorkStart) {
        $this->ageWorkStart = $ageWorkStart;
    }

    function setAgeWorkEnd($ageWorkEnd) {
        $this->ageWorkEnd = $ageWorkEnd;
    }

    function setGenderId($genderId) {
        $this->genderId = $genderId;
    }

    function setEmployeeTypeId($employeeTypeId) {
        $this->employeeTypeId = $employeeTypeId;
    }

    function setReturnTypeId($returnTypeId) {
        $this->returnTypeId = $returnTypeId;
    }

}
