<?php

namespace apps\wfmember\entity;

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
     * @Column(type="string", name="description",nullable=true)
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
    
    public $conditions;
    
    function getConditions() {
        return $this->conditions;
    }

    function setConditions($conditions) {
        $this->conditions = $conditions;
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

}
