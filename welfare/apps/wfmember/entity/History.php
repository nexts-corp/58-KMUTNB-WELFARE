<?php

namespace apps\wfmember\entity;
use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="WelfareHistory")
 */
class History extends EntityBase{

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="historyId") */
    public $historyId;

    /**
     * @Column(type="integer",length=11, name="detailsId")
     */
    public $detailsId;
    
     /**
     * @Column(type="integer",length=11, name="welfareId")
     */
    public $welfareId;
    
       /**
     * @Column(type="integer",length=11, name="memberId")
     */
    public $memberId;

    /**
     * @Column(type="date", name="dateUse",nullable=true)
     */
    public $dateUse;
    
   /**
     * @Column(type="string", length=11,  name="amount",nullable=true)
     */
    public $amount;
    
      
       /**
     * @Column(type="string",length=255, name="remark",nullable=true)
     */
    public $remark;
    
    
    function getHistoryId() {
        return $this->historyId;
    }

    function getDetailsId() {
        return $this->detailsId;
    }

    function getWelfareId() {
        return $this->welfareId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getDateUse() {
        return $this->dateUse;
    }

    function getAmount() {
        return $this->amount;
    }

    function getRemark() {
        return $this->remark;
    }

    function setHistoryId($historyId) {
        $this->historyId = $historyId;
    }

    function setDetailsId($detailsId) {
        $this->detailsId = $detailsId;
    }

    function setWelfareId($welfareId) {
        $this->welfareId = $welfareId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setDateUse($dateUse) {
        $this->dateUse = $dateUse;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }


}
