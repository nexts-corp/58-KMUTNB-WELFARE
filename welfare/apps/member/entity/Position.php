<?php
namespace apps\member\entity;
use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="MemberPosition")
 */
class Position extends EntityBase{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="positionId") 
     */
    public $positionId;

    /**
     * @Column(type="integer", length=11, name="memberId") 
     */
    public $memberId; 
    
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
     * @Column(type="string", length=10, name="positionCode",nullable=true) 
     */
    public $positionCode;

    /**
     * @Column(type="string", length=10, name="matierId",nullable=true) 
     */
    public $matierId;
    
    function getPositionId() {
        return $this->positionId;
    }

    function getMemberId() {
        return $this->memberId;
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

    function getPositionCode() {
        return $this->positionCode;
    }

    function getMatierId() {
        return $this->matierId;
    }

    function setPositionId($positionId) {
        $this->positionId = $positionId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
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

    function setPositionCode($positionCode) {
        $this->positionCode = $positionCode;
    }

    function setMatierId($matierId) {
        $this->matierId = $matierId;
    }




}
