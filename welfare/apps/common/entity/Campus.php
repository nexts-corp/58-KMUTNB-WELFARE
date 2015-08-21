<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Campus")
     */
class Campus {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="campusId") */
       public $campusId;
       
        /**
        *@Column(type="string" , length=255, name="campusName") 
        */
       public $campusName;
       
        /**
        *@Column(type="string" , length=255, name="address") 
        */
       public $address;
       function getCampusId() {
           return $this->campusId;
       }

       function getCampusName() {
           return $this->campusName;
       }

       function getAddress() {
           return $this->address;
       }

       function setCampusId($campusId) {
           $this->campusId = $campusId;
       }

       function setCampusName($campusName) {
           $this->campusName = $campusName;
       }

       function setAddress($address) {
           $this->address = $address;
       }





}
