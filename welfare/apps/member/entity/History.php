<?php

namespace apps\member\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="MemberHistory")
 */
class History extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="historyId") */
    public $historyId;

    /**
     * @Column(type="integer", length=11, name="memberId",nullable=true) 
     */
    public $memberId;

    /**
     * @Column(type="string", length=100, name="entityChange",nullable=true) 
     */
    public $entityChange;

    /**
     * @Column(type="string", length=100, name="fieldChange",nullable=true) 
     */
    public $fieldChange;

    /**
     * @Column(type="string", length=255, name="valueOld",nullable=true) 
     */
    public $valueOld;

    /**
     * @Column(type="string", length=255, name="valueNew",nullable=true) 
     */
    public $valueNew;

    function getHistoryId() {
        return $this->historyId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getEntityChange() {
        return $this->entityChange;
    }

    function getFieldChange() {
        return $this->fieldChange;
    }

    function getValueOld() {
        return $this->valueOld;
    }

    function getValueNew() {
        return $this->valueNew;
    }

    function setHistoryId($historyId) {
        $this->historyId = $historyId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setEntityChange($entityChange) {
        $this->entityChange = $entityChange;
    }

    function setFieldChange($fieldChange) {
        $this->fieldChange = $fieldChange;
    }

    function setValueOld($valueOld) {
        $this->valueOld = $valueOld;
    }

    function setValueNew($valueNew) {
        $this->valueNew = $valueNew;
    }

}
