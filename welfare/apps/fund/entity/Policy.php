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
 * @Table(name="FundPolicy")
 */
class Policy extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="policyId") 
     */
    public $policyId;

    /**
     * @Column(type="string", length=255, name="name",nullable=true)
     */
    public $name;

    /**
     * @Column(type="string", length=255, name="description",nullable=true)
     */
    public $description;

    /**
     * @Column(type="string", length=10, name="fundTypeId",nullable=true)
     */
    public $fundTypeId;

    function getPolicyId() {
        return $this->policyId;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getFundTypeId() {
        return $this->fundTypeId;
    }

    function setPolicyId($policyId) {
        $this->policyId = $policyId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setFundTypeId($fundTypeId) {
        $this->fundTypeId = $fundTypeId;
    }

}
