<?php
namespace apps\user\entity;
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
     * @Column(type="integer", length=11, name="memberId",nullable=true) 
     */
    public $memberId;
    
     /**
     * @Column(type="string", length=11, name="userTypeId",nullable=true) 
     */
    public $userTypeId;
    
    function getUserId() {
        return $this->userId;
    }

    function getUserName() {
        return $this->userName;
    }

    function getPassword() {
        return $this->password;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getUserTypeId() {
        return $this->userTypeId;
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

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setUserTypeId($userTypeId) {
        $this->userTypeId = $userTypeId;
    }


}
