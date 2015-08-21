<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="Resign")
 */
class Resign {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="registerId") */
    public $registerId;

    /**
     * @Column(type="date", name="dateResign") 
     */
    public $dateResign;

    /**
     * @Column(type="date", name="detailResign") 
     */
    public $detailResign;

    /**
     * @Column(type="string", name="statusResign") 
     */
    public $statusResign;
    function getRegisterId() {
        return $this->registerId;
    }

    function getDateResign() {
        return $this->dateResign;
    }

    function getDetailResign() {
        return $this->detailResign;
    }

    function getStatusResign() {
        return $this->statusResign;
    }

    function setRegisterId($registerId) {
        $this->registerId = $registerId;
    }

    function setDateResign($dateResign) {
        $this->dateResign = $dateResign;
    }

    function setDetailResign($detailResign) {
        $this->detailResign = $detailResign;
    }

    function setStatusResign($statusResign) {
        $this->statusResign = $statusResign;
    }


}
