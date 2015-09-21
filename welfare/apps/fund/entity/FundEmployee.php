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
 * @Table(name="FundEmployee")
 */
class FundEmployee extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="fundEmpId") 
     */
    public $fundEmpId;

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
     * @Column(type="float", name="myBenefit",nullable=true)
     */
    public $myBenefit;

    /**
     * @Column(type="float", name="employerBenefit",nullable=true)
     */
    public $employerBenefit;

    /**
     * @Column(type="float", name="grantInAid",nullable=true)
     */
    public $grantInAid;

    /**
     * @Column(type="float", name="total",nullable=true)
     */
    public $total;

    /**
     * @Column(type="date", name="dateNotice",nullable=true)
     */
    public $dateNotice;

    /**
     * @Column(type="string",length=30, name="filename",nullable=true)
     */
    public $filename;

    function getFundEmpId() {
        return $this->fundEmpId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getSaving() {
        return $this->saving;
    }

    function getMyBenefit() {
        return $this->myBenefit;
    }

    function getEmployerBenefit() {
        return $this->employerBenefit;
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

    function setFundEmpId($fundEmpId) {
        $this->fundEmpId = $fundEmpId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setSaving($saving) {
        $this->saving = $saving;
    }

    function setMyBenefit($myBenefit) {
        $this->myBenefit = $myBenefit;
    }

    function setEmployerBenefit($employerBenefit) {
        $this->employerBenefit = $employerBenefit;
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
