<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="User")
 */
class User {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="userId") */
    public $userId;

    /**
     * @Column(type="string", length=255, name="userName") 
     */
    public $userName;

    /**
     * @Column(type="string", length=255, name="password",nullable=true) 
     */
    public $password;

    /**
     * @Column(type="integer", length=11, name="registerId",nullable=true) 
     */
    public $registerId;

    /**
     * @Column(type="integer", length=11, name="SuperAdminId",nullable=true) 
     */
    public $SuperAdminId;

    /**
     * @Column(type="integer", length=11, name="facultyId",nullable=true) 
     */
    public $facultyId;

    /**
     * @Column(type="integer", length=11, name="departmentId",nullable=true) 
     */
    public $departmentId;
    
    /**
     * @Column(type="string", length=11, name="userTypeId",nullable=true) 
     */
    public $userTypeId;
    
    function getUserTypeId() {
        return $this->userTypeId;
    }

    function setUserTypeId($userTypeId) {
        $this->userTypeId = $userTypeId;
    }

        function getUserId() {
        return $this->userId;
    }

    function getUserName() {
        return $this->userName;
    }

    function getPassword() {
        return $this->password;
    }

    function getRegisterId() {
        return $this->registerId;
    }

    function getSuperAdminId() {
        return $this->SuperAdminId;
    }

    function getFacultyId() {
        return $this->facultyId;
    }

    function getDepartmentId() {
        return $this->departmentId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setRegisterId($registerId) {
        $this->registerId = $registerId;
    }

    function setSuperAdminId($SuperAdminId) {
        $this->SuperAdminId = $SuperAdminId;
    }

    function setFacultyId($facultyId) {
        $this->facultyId = $facultyId;
    }

    function setDepartmentId($departmentId) {
        $this->departmentId = $departmentId;
    }


}
