<?php

namespace apps\insurance\entity;
use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="insuranceBeneficiary")
 */
class Beneficiary extends EntityBase{

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="beneficiaryId") */
    public $beneficiaryId;

    /**
     * @Column(type="integer" , length=13, name="lifeId",nullable=true) 
     */
    public $lifeId;

    /**
     * @Column(type="string" , length=255, name="ffname",nullable=true) 
     */
    public $ffname;

    /**
     * @Column(type="string" , length=255, name="flname",nullable=true) 
     */
    public $flname;

    /**
     * @Column(type="string" , length=13, name="fidCard",nullable=true) 
     */
    public $fidCard;

    /**
     * @Column(type="string" , length=255, name="faddress",nullable=true) 
     */
    public $faddress;

    /**
     * @Column(type="string" , length=255, name="ftelephone",nullable=true) 
     */
    public $ftelephone;

    /**
     * @Column(type="string" , name="fdob",nullable=true) 
     */
    public $fdob;

    /**
     * @Column(type="string" , length=255, name="relationId",nullable=true) 
     */
    public $relationId;

    /**
     * @Column(type="string", length=10, name="titleNameId",nullable=true) 
     */
    public $titleNameId;

    /**
     * @Column(type="string", length=10, name="academicId",nullable=true) 
     */
    public $academicId;

    /**
     * @Column(type="string", length=255, name="fmobile",nullable=true) 
     */
    public $fmobile;

    /**
     * @Column(type="string", length=255, name="femail",nullable=true) 
     */
    public $femail;
    
    /**
     * @Column(type="string", length=255, name="ratio",nullable=true) 
     */
    public $ratio;
    
    function getBeneficiaryId() {
        return $this->beneficiaryId;
    }

    function getLifeId() {
        return $this->lifeId;
    }

    function getFfname() {
        return $this->ffname;
    }

    function getFlname() {
        return $this->flname;
    }

    function getFidCard() {
        return $this->fidCard;
    }

    function getFaddress() {
        return $this->faddress;
    }

    function getFtelephone() {
        return $this->ftelephone;
    }

    function getFdob() {
        return $this->fdob;
    }

    function getRelationId() {
        return $this->relationId;
    }

    function getTitleNameId() {
        return $this->titleNameId;
    }

    function getAcademicId() {
        return $this->academicId;
    }

    function getFmobile() {
        return $this->fmobile;
    }

    function getFemail() {
        return $this->femail;
    }

    function getRatio() {
        return $this->ratio;
    }

    function setBeneficiaryId($beneficiaryId) {
        $this->beneficiaryId = $beneficiaryId;
    }

    function setLifeId($lifeId) {
        $this->lifeId = $lifeId;
    }

    function setFfname($ffname) {
        $this->ffname = $ffname;
    }

    function setFlname($flname) {
        $this->flname = $flname;
    }

    function setFidCard($fidCard) {
        $this->fidCard = $fidCard;
    }

    function setFaddress($faddress) {
        $this->faddress = $faddress;
    }

    function setFtelephone($ftelephone) {
        $this->ftelephone = $ftelephone;
    }

    function setFdob($fdob) {
        $this->fdob = $fdob;
    }

    function setRelationId($relationId) {
        $this->relationId = $relationId;
    }

    function setTitleNameId($titleNameId) {
        $this->titleNameId = $titleNameId;
    }

    function setAcademicId($academicId) {
        $this->academicId = $academicId;
    }

    function setFmobile($fmobile) {
        $this->fmobile = $fmobile;
    }

    function setFemail($femail) {
        $this->femail = $femail;
    }

    function setRatio($ratio) {
        $this->ratio = $ratio;
    }


    
}
