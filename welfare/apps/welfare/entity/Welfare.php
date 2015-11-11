<?php

namespace apps\welfare\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="Welfare")
 */
class Welfare extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="welfareId") */
    public $welfareId;

    /**
     * @Column(type="string", name="name",length=255) 
     */
    public $name;

    /**
     * @Column(type="string",length=100, name="code") 
     */
    public $code;

    /**
     * @Column(type="string", name="description",nullable=true) 
     */
    public $description;

    /**
     * @Column(type="string", name="statusActive",nullable=true,length=10) 
     */
    public $statusActive;

    /**
     * @Column(type="date", name="dateStart",nullable=true) 
     */
    public $dateStart;

    /**
     * @Column(type="date", name="dateEnd",nullable=true) 
     */
    public $dateEnd;

    /**
     * @Column(type="string", name="free",nullable=true) 
     */
    public $free;

    /**
     * @Column(type="string", name="willing",nullable=true) 
     */
    public $willing;

    /**
     * @Column(type="string", name="retire",nullable=true) 
     */
    public $retire;

    /**
     * @Column(type="integer", length=11, name="resetTime",nullable=true)
     */
    public $resetTime; // (เดือน)

    /**
     * @Column(type="string", name="filename",length=100,nullable=true) 
     */
    public $filename;
    public $details;

    function getWelfareId() {
        return $this->welfareId;
    }

    function getName() {
        return $this->name;
    }

    function getCode() {
        return $this->code;
    }

    function getDescription() {
        return $this->description;
    }

    function getStatusActive() {
        return $this->statusActive;
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

    function getResetTime() {
        return $this->resetTime;
    }

    function getFilename() {
        return $this->filename;
    }

    function getDetails() {
        return $this->details;
    }

    function setWelfareId($welfareId) {
        $this->welfareId = $welfareId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setStatusActive($statusActive) {
        $this->statusActive = $statusActive;
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

    function setResetTime($resetTime) {
        $this->resetTime = $resetTime;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setDetails($details) {
        $this->details = $details;
    }

}
