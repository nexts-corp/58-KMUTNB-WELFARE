<?php

namespace apps\welfare\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="WelfareDetails")
 */
class Details extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="detailsId") */
    public $detailsId;

    /**
     * @Column(type="integer",length=11, name="welfareId")
     */
    public $welfareId;

    /**
     * @Column(type="string", length=255,name="description",nullable=true)
     */
    public $description;

    /**
     * @Column(type="integer", length=11, name="quantity" ) 
     */
    public $quantity;

    /**
     * @Column(type="string", length=10, name="returnTypeId",nullable=true)
     */
    public $returnTypeId; //หน่วยนับ

    /**
     * @Column(type="string", name="filename",length=100,nullable=true) 
     */
    public $filename;

    /**
     * @Column(type="string", name="statusActive",nullable=true,length=10) 
     */
    public $statusActive;
    public $conditions;

    function getStatusActive() {
        return $this->statusActive;
    }

    function setStatusActive($statusActive) {
        $this->statusActive = $statusActive;
    }

    function getDetailsId() {
        return $this->detailsId;
    }

    function getWelfareId() {
        return $this->welfareId;
    }

    function getDescription() {
        return $this->description;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function getReturnTypeId() {
        return $this->returnTypeId;
    }

    function getFilename() {
        return $this->filename;
    }

    function getConditions() {
        return $this->conditions;
    }

    function setDetailsId($detailsId) {
        $this->detailsId = $detailsId;
    }

    function setWelfareId($welfareId) {
        $this->welfareId = $welfareId;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    function setReturnTypeId($returnTypeId) {
        $this->returnTypeId = $returnTypeId;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setConditions($conditions) {
        $this->conditions = $conditions;
    }

}
