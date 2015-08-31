<?php
namespace apps\welfare\entity;
/**
     * @Entity
     * @Table(name="Welfare")
     */
class Welfare {
   /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="welfareId") */
       public $welfareId;
       
        /**
        *@Column(type="string", name="name") 
        */
       public $name;
       
       /**
        *@Column(type="string", name="description",nullable=true) 
        */
       public $description;
       
       /**
        *@Column(type="datetime", name="dateCreate",length=14,nullable=true) 
        */
       public $dateCreate;
       
       /**
        *@Column(type="date", name="dateUpdate",nullable=true) 
        */
       public $dateUpdate;
       
       /**
        *@Column(type="date", name="dateCande",nullable=true) 
        */
       public $dateCande;
       
        /**
        *@Column(type="date", name="dateStart",nullable=true) 
        */
       public $dateStart;
       
       /**
        *@Column(type="date", name="dateEnd",nullable=true) 
        */
       public $dateEnd;
       
       /**
        *@Column(type="string", name="free",nullable=true) 
        */
       public $free;
       
       /**
        *@Column(type="string", name="willing",nullable=true) 
        */
       public $willing;
       /**
        *@Column(type="string", name="retire",nullable=true) 
        */
       public $retire;
       
       
       
       
       function getWelfareId() {
           return $this->welfareId;
       }

       function getName() {
           return $this->name;
       }

       function getDescription() {
           return $this->description;
       }

       function getDateCreate() {
           return $this->dateCreate;
       }

       function getDateUpdate() {
           return $this->dateUpdate;
       }

       function getDateCande() {
           return $this->dateCande;
       }

       function getDateStart() {
           return $this->dateStart;
       }

       function getDateEnd() {
           return $this->dateEnd;
       }

       function getFree() {
           return $this->free;
       }

       function getWilling() {
           return $this->willing;
       }

       function getRetire() {
           return $this->retire;
       }

       function setWelfareId($welfareId) {
           $this->welfareId = $welfareId;
       }

       function setName($name) {
           $this->name = $name;
       }

       function setDescription($description) {
           $this->description = $description;
       }

       function setDateCreate($dateCreate) {
           $this->dateCreate = $dateCreate;
       }

       function setDateUpdate($dateUpdate) {
           $this->dateUpdate = $dateUpdate;
       }

       function setDateCande($dateCande) {
           $this->dateCande = $dateCande;
       }

       function setDateStart($dateStart) {
           $this->dateStart = $dateStart;
       }

       function setDateEnd($dateEnd) {
           $this->dateEnd = $dateEnd;
       }

       function setFree($free) {
           $this->free = $free;
       }

       function setWilling($willing) {
           $this->willing = $willing;
       }

       function setRetire($retire) {
           $this->retire = $retire;
       }




}
