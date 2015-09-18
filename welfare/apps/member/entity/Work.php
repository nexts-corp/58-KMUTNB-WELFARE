<?php
namespace apps\member\entity;
use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="MemberWork")
 */
class Work extends EntityBase{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="workId") 
     */
    public $workId;

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
     * @Column(type="string", length=10, name="positionId",nullable=true) 
     */
    public $positionId;

    /**
     * @Column(type="string", length=10, name="matierId",nullable=true) 
     */
    public $matierId;
    
    function getWorkId() {
        return $this->workId;
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

    function getPositionId() {
        return $this->positionId;
    }

    function getMatierId() {
        return $this->matierId;
    }

    function setWorkId($workId) {
        $this->workId = $workId;
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

    function setPositionId($positionId) {
        $this->positionId = $positionId;
    }

    function setMatierId($matierId) {
        $this->matierId = $matierId;
    }






}
