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
     * @Column(type="string", length=255, name="username") 
     */
    public $username;

    /**
     * @Column(type="string", length=255, name="password",nullable=true) 
     */
    public $password;

    /**
     * @Column(type="integer", length=11, name="memberId",nullable=true) 
     */
    public $memberId;
    
     /**
     * @Column(type="string", length=10, name="userTypeId",nullable=true) 
     */
    public $userTypeId;
    
    public $oldpassword;
    
    public $confirmpassword;
            
    function getUserId() {
        return $this->userId;
    }

    function getUsername() {
        return $this->username;
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

    function setUsername($username) {
        $this->username = $username;
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
