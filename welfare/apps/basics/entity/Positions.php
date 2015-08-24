<?php

namespace apps\basics\entity;

/**
 * @Entity
 * @Table(name="Positions")
 */
class Positions {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="positionsId") */
    public $positionsId;

    /**
     * @Column(type="string" , length=255, name="positionsNameTh") 
     */
    public $positionsNameTh;

    /**
     * @Column(type="string" , length=255, name="positionsNameEn") 
     */
    public $positionsNameEn;

    function getPositionsId() {
        return $this->positionsId;
    }

    function getPositionsNameTh() {
        return $this->positionsNameTh;
    }

    function getPositionsNameEn() {
        return $this->positionsNameEn;
    }

    function setPositionsId($positionsId) {
        $this->positionsId = $positionsId;
    }

    function setPositionsNameTh($positionsNameTh) {
        $this->positionsNameTh = $positionsNameTh;
    }

    function setPositionsNameEn($positionsNameEn) {
        $this->positionsNameEn = $positionsNameEn;
    }

}
