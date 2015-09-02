<?php

namespace apps\welfare\entity;

/**
 * @Entity
 * @Table(name="WelfareRight")
 */
class Right {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="rightId") */
    public $rightId;

    /**
     * @Column(type="integer",length=11, name="conditionsId")
     */
    public $conditionsId;

    /**
     * @Column(type="string", name="memberId",nullable=true)
     */
    public $memberId;

    function getRightId() {
        return $this->rightId;
    }

    function getConditionsId() {
        return $this->conditionsId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function setRightId($rightId) {
        $this->rightId = $rightId;
    }

    function setConditionsId($conditionsId) {
        $this->conditionsId = $conditionsId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }


}
