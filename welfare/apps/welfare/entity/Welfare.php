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
     * @Column(type="string", name="name") 
     */
    public $name;

    /**
     * @Column(type="string", name="description",nullable=true) 
     */
    public $description;

    /**
     * @Column(type="date", name="dateCancel",nullable=true) 
     */
    public $dateCancel;

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
    public $resetTime; //เวลาresetสวัสดิการ (เดือน)

    function getWelfareId() {
        return $this->welfareId;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getDateCancel() {
        return $this->dateCancel;
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

    function setWelfareId($welfareId) {
        $this->welfareId = $welfareId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setDateCancel($dateCancel) {
        $this->dateCancel = $dateCancel;
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

}
