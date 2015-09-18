<?php

namespace apps\member\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="MemberContract")
 */
class Contract extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="contactId") 
     */
    public $contactId;

    /**
     * @Column(type="integer", length=11, name="memberId") 
     */
    public $memberId;
    
    /**
     * @Column(type="string", length=255, name="address",nullable=true) 
     */
    public $address;

    /**
     * @Column(type="string", length=255, name="internalPhone",nullable=true) 
     */
    public $internalPhone;

    /**
     * @Column(type="string", length=255, name="phone",nullable=true) 
     */
    public $phone;

    /**
     * @Column(type="string", length=255, name="mobile",nullable=true) 
     */
    public $mobile;

    /**
     * @Column(type="string", length=255, name="email",nullable=true) 
     */
    public $email;

    function getContactId() {
        return $this->contactId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getAddress() {
        return $this->address;
    }

    function getInternalPhone() {
        return $this->internalPhone;
    }

    function getPhone() {
        return $this->phone;
    }

    function getMobile() {
        return $this->mobile;
    }

    function getEmail() {
        return $this->email;
    }

    function setContactId($contactId) {
        $this->contactId = $ccontactId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setInternalPhone($internalPhone) {
        $this->internalPhone = $internalPhone;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    function setEmail($email) {
        $this->email = $email;
    }


}
