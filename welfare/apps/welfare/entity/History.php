<?php

namespace apps\welfare\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="WelfareHistory")
 */
class History extends EntityBase {

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
     * @Column(type="integer", length=11,  name="amount",nullable=true)
     */
    public $amount;

    /**
     * @Column(type="string", length=10,  name="statusApprove",nullable=true)
     */
    public $statusApprove;

    /**
     * @Column(type="string",length=255, name="remark",nullable=true)
     */
    
    public $remark;
    public $nftAppId;
    public $nftAppName;
    public $nftName;
    public $nftStatus;
    
    function getNftAppId() {
        return $this->nftAppId;
    }

    function getNftAppName() {
        return $this->nftAppName;
    }

    function getNftName() {
        return $this->nftName;
    }

    function getNftStatus() {
        return $this->nftStatus;
    }

    function setNftAppId($nftAppId) {
        $this->nftAppId = $nftAppId;
    }

    function setNftAppName($nftAppName) {
        $this->nftAppName = $nftAppName;
    }

    function setNftName($nftName) {
        $this->nftName = $nftName;
    }

    function setNftStatus($nftStatus) {
        $this->nftStatus = $nftStatus;
    }

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

    function getStatusApprove() {
        return $this->statusApprove;
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

    function setStatusApprove($statusApprove) {
        $this->statusApprove = $statusApprove;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }

}
