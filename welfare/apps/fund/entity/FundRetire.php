<?php

namespace apps\fund\entity;

use apps\common\entity\EntityBase;

/**
 * Description of Insurance
 *
 * @author tawatchai
 */

/**
 * @Entity
 * @Table(name="FundRetire")
 */
class FundRetire extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="fundReId") 
     */
    public $fundReId;

    /**
     * @Column(type="integer", length=11, name="policyId",nullable=true)
     */
    public $policyId;

    /**
     * @Column(type="integer", length=11, name="memberId",nullable=true)
     */
    public $memberId;

    /**
     * @Column(type="float", name="saving",nullable=true)
     */
    public $saving;

    /**
     * @Column(type="float", name="grantInAid",nullable=true)
     */
    public $grantInAid;

    /**
     * @Column(type="float", name="total",nullable=true)
     */
    public $total;

    /**
     * @Column(type="date",name="dateNotice",nullable=true)
     */
    public $dateNotice;

    /**
     * @Column(type="string",length=30, name="filename",nullable=true)
     */
    public $filename;

    function getFundReId() {
        return $this->fundReId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getSaving() {
        return $this->saving;
    }

    function getGrantInAid() {
        return $this->grantInAid;
    }

    function getTotal() {
        return $this->total;
    }

    function getDateNotice() {
        return $this->dateNotice;
    }

    function getFilename() {
        return $this->filename;
    }

    function setFundReId($fundReId) {
        $this->fundReId = $fundReId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setSaving($saving) {
        $this->saving = $saving;
    }

    function setGrantInAid($grantInAid) {
        $this->grantInAid = $grantInAid;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setDateNotice($dateNotice) {
        $this->dateNotice = $dateNotice;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

}
