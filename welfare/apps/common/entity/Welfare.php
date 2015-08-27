<?php
namespace apps\common\entity;
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
        *@Column(type="string", name="description") 
        */
       public $description;
       
       /**
        *@Column(type="date", name="dateCreate") 
        */
       public $dateCreate;
       
       /**
        *@Column(type="date", name="dateUpdate") 
        */
       public $dateUpdate;
       
       /**
        *@Column(type="date", name="dateCande") 
        */
       public $dateCande;
       
        /**
        *@Column(type="date", name="dateStart") 
        */
       public $dateStart;
       
       /**
        *@Column(type="date", name="dateEnd") 
        */
       public $dateEnd;
       
       /**
        *@Column(type="string", name="free") 
        */
       public $free;
       
       /**
        *@Column(type="string", name="willing") 
        */
       public $willing;
       /**
        *@Column(type="string", name="retire") 
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
