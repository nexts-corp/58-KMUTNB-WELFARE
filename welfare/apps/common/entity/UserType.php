<?php
namespace apps\common\entity;
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
        *@Column(type="string", length=255, name="userTypeName") 
        */
       public $userTypeName;
       function getUserTypeId() {
           return $this->userTypeId;
       }

       function getUserTypeName() {
           return $this->userTypeName;
       }

       function setUserTypeId($userTypeId) {
           $this->userTypeId = $userTypeId;
       }

       function setUserTypeName($userTypeName) {
           $this->userTypeName = $userTypeName;
       }


  

       
       


}
