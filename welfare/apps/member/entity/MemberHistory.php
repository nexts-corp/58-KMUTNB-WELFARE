<?php
namespace apps\member\entity;

/**
 * @Entity
 * @Table(name="MemberHistory")
 */

class MemberHistory {
    
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="historyId") */
    public $historyId;
    
    /**
     * @Column(type="string", length=255, name="memberId",nullable=true) 
     */
    public $memberId;
    
    /**
     * @Column(type="string", length=255, name="field",nullable=true) 
     */
    public $field;
    
    /**
     * @Column(type="string", length=255, name="old",nullable=true) 
     */
    public $old;
    
    /**
     * @Column(type="string", length=255, name="new",nullable=true) 
     */
    public $new;
    
    /**
     * @Column(type="date", name="dateCreate") 
     */
    public $dateCreate;
    
    
    function getHistoryId() {
        return $this->historyId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getField() {
        return $this->field;
    }

    function getOld() {
        return $this->old;
    }

    function getNew() {
        return $this->new;
    }

    function getDateCreate() {
        return $this->dateCreate;
    }

    function setHistoryId($historyId) {
        $this->historyId = $historyId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setField($field) {
        $this->field = $field;
    }

    function setOld($old) {
        $this->old = $old;
    }

    function setNew($new) {
        $this->new = $new;
    }

    function setDateCreate($dateCreate) {
        $this->dateCreate = $dateCreate;
    }


}
