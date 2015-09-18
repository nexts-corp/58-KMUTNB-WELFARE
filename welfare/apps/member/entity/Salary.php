<?php

namespace apps\member\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="MemberSalary")
 */
class Salary extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="salaryId") 
     */
    public $salaryId;

    /**
     * @Column(type="integer", length=11, name="memberId") 
     */
    public $memberId;

    /**
     * @Column(type="string", length=255, name="rank",nullable=true) 
     */
    public $rank;

    /**
     * @Column(type="float", name="salary",nullable=true) 
     */
    public $salary;

    /**
     * @Column(type="date", name="salaryDate",nullable=true) 
     */
    public $salaryDate;

    function getSalaryId() {
        return $this->salaryId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getRank() {
        return $this->rank;
    }

    function getSalary() {
        return $this->salary;
    }

    function getDateStart() {
        return $this->dateStart;
    }

    function setSalaryId($salaryId) {
        $this->salaryId = $salaryId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setRank($rank) {
        $this->rank = $rank;
    }

    function setSalary($salary) {
        $this->salary = $salary;
    }

    function setDateStart($dateStart) {
        $this->dateStart = $dateStart;
    }

}
