<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="PositionsType")
 */
class PositionsType {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="positionsTypeId") */
    public $positionsTypeId;

    /**
     * @Column(type="string" , length=255, name="positionsTypeNameTh") 
     */
    public $positionsTypeNameTh;

    /**
     * @Column(type="string" , length=255, name="positionsTypeNameEn") 
     */
    public $positionsTypeNameEn;

    function getPositionsTypeId() {
        return $this->positionsTypeId;
    }

    function getPositionsTypeNameTh() {
        return $this->positionsTypeNameTh;
    }

    function getPositionsTypeNameEn() {
        return $this->positionsTypeNameEn;
    }

    function setPositionsTypeId($positionsTypeId) {
        $this->positionsTypeId = $positionsTypeId;
    }

    function setPositionsTypeNameTh($positionsTypeNameTh) {
        $this->positionsTypeNameTh = $positionsTypeNameTh;
    }

    function setPositionsTypeNameEn($positionsTypeNameEn) {
        $this->positionsTypeNameEn = $positionsTypeNameEn;
    }

}
