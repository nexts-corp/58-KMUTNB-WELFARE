<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Positions")
     */
class Positions {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="positionsId") */
       public $positionsId;
       
        /**
        *@Column(type="string" , length=255, name="positionsNameTH") 
        */
       public $positionsNameTH;
       
       /**
        *@Column(type="string" , length=255, name="positionsNameEN") 
        */
       public $positionsNameEN;
       
       /**
        *@Column(type="string" , length=255, name="relationStatus") 
        */
       public $relationStatus;
       
       /**
        *@Column(type="string" , length=255, name="status") 
        */
        public $status;
       
       /**
        *@Column(type="string" , length=255, name="owner") 
        */
       public $owner;
       
       /**
        *@Column(type="integer" , length=255, name="version") 
        */
       public $version;
       
       /**
        *@Column(type="datetime" , name="creationTime") 
        */
       public $creationTime;
       
       /**
        *@Column(type="integer" , length=20, name="creationUser") 
        */
       public $creationUser;
       
       /**
        *@Column(type="dateTime", name="whenModified") 
        */
       public $whenModified;
       
       function getPositionsId() {
           return $this->positionsId;
       }

       function getPositionsNameTH() {
           return $this->positionsNameTH;
       }

       function getPositionsNameEN() {
           return $this->positionsNameEN;
       }

       function getRelationStatus() {
           return $this->relationStatus;
       }

       function getStatus() {
           return $this->status;
       }

       function getOwner() {
           return $this->owner;
       }

       function getVersion() {
           return $this->version;
       }

       function getCreationTime() {
           return $this->creationTime;
       }

       function getCreationUser() {
           return $this->creationUser;
       }

       function getWhenModified() {
           return $this->whenModified;
       }

       function setPositionsId($positionsId) {
           $this->positionsId = $positionsId;
       }

       function setPositionsNameTH($positionsNameTH) {
           $this->positionsNameTH = $positionsNameTH;
       }

       function setPositionsNameEN($positionsNameEN) {
           $this->positionsNameEN = $positionsNameEN;
       }

       function setRelationStatus($relationStatus) {
           $this->relationStatus = $relationStatus;
       }

       function setStatus($status) {
           $this->status = $status;
       }

       function setOwner($owner) {
           $this->owner = $owner;
       }

       function setVersion($version) {
           $this->version = $version;
       }

       function setCreationTime($creationTime) {
           $this->creationTime = $creationTime;
       }

       function setCreationUser($creationUser) {
           $this->creationUser = $creationUser;
       }

       function setWhenModified($whenModified) {
           $this->whenModified = $whenModified;
       }




}
