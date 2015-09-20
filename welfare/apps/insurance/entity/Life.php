<?php

namespace apps\insurance\entity;

use apps\common\entity\EntityBase;

/**
 * Description of Insurance
 *
 * @author tawatchai
 */

/**
 * @Entity
 * @Table(name="InsuranceLife")
 */
class Life extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="lifeId") 
     */
    public $lifeId;

    /**
     * @Column(type="integer", length=11, name="memberId",nullable=true)
     */
    public $memberId;

    /**
     * @Column(type="string", length=10, name="payment",nullable=true)
     */
    public $payment;

    /**
     * @Column(type="string", length=10, name="received",nullable=true)
     */
    public $received;

    /**
     * @Column(type="string",length=4, name="protectYear",nullable=true)
     */
    public $protectYear;

    /**
     * @Column(type="string", length=30,name="filename",nullable=true)
     */
    public $filename;

    function getLifeId() {
        return $this->lifeId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getPayment() {
        return $this->payment;
    }

    function getReceived() {
        return $this->received;
    }

    function getProtectYear() {
        return $this->protectYear;
    }

    function getFilename() {
        return $this->filename;
    }

    function setLifeId($lifeId) {
        $this->lifeId = $lifeId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setPayment($payment) {
        $this->payment = $payment;
    }

    function setReceived($received) {
        $this->received = $received;
    }

    function setProtectYear($protectYear) {
        $this->protectYear = $protectYear;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

}
