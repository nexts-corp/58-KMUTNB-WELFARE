<?php
namespace apps\user\entity;
/**
     * @Entity
     * @Table(name="UserType")
     */
class UserType {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="userTypeId") */
       public $userTypeId;
       
        /**
        *@Column(type="string", length=255, name="userType") 
        */
       public $userType;
       
       function getUserTypeId() {
           return $this->userTypeId;
       }

       function getUserType() {
           return $this->userType;
       }

       function setUserTypeId($userTypeId) {
           $this->userTypeId = $userTypeId;
       }

       function setUserType($userType) {
           $this->userType = $userType;
       }


}
