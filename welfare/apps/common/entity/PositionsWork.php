<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="positionswork")
 */
class PositionsWork {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="positionsWorkId") */
    public $positionsWorkId;

    /**
     * @Column(type="string" , length=255, name="positionsWorkNameTh") 
     */
    public $positionsWorkNameTh;

    /**
     * @Column(type="string" , length=255, name="positionsWorkNameEn") 
     */
    public $positionsWorkNameEn;

    function getPositionsWorkId() {
        return $this->positionsWorkId;
    }

    function getPositionsWorkNameTh() {
        return $this->positionsWorkNameTh;
    }

    function getPositionsWorkNameEn() {
        return $this->positionsWorkNameEn;
    }

    function setPositionsWorkId($positionsWorkId) {
        $this->positionsWorkId = $positionsWorkId;
    }

    function setPositionsWorkNameTh($positionsWorkNameTh) {
        $this->positionsWorkNameTh = $positionsWorkNameTh;
    }

    function setPositionsWorkNameEn($positionsWorkNameEn) {
        $this->positionsWorkNameEn = $positionsWorkNameEn;
    }

}
