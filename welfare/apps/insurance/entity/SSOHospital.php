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
 * @Table(name="SSOHospital")
 */
class SSOHospital extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="id") 
     */
    public $id;

    /**
     * @Column(type="integer", length=11, name="memberId",nullable=true)
     */
    public $memberId;

    /**
     * @Column(type="string", length=13, name="idCard",nullable=true)
     */
    public $idCard;

    /**
     * @Column(type="string", length=255, name="hospital",nullable=true)
     */
    public $hospital;


    
    function getId() {
        return $this->id;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getIdCard() {
        return $this->idCard;
    }

    function getHospital() {
        return $this->hospital;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setIdCard($idCard) {
        $this->idCard = $idCard;
    }

    function setHospital($hospital) {
        $this->hospital = $hospital;
    }





}
