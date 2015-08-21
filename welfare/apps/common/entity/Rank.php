<?php

namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="Rank")
 */
class Rank  {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="rankId") */
    public $rankId;

    /**
     * @Column(type="string" , length=255, name="rankNameTh") 
     */
    public $rankNameTh;

    /**
     * @Column(type="string" , length=255, name="rankNameEn") 
     */
    public $rankNameEn;

    /**
     * @Column(type="string" , length=255, name="abbreviationTh") 
     */
    public $abbreviationTh;

    /**
     * @Column(type="string" , length=255, name="abbreviationEn") 
     */
    public $abbreviationEn;
    function getRankId() {
        return $this->rankId;
    }

    function getRankNameTh() {
        return $this->rankNameTh;
    }

    function getRankNameEn() {
        return $this->rankNameEn;
    }

    function getAbbreviationTh() {
        return $this->abbreviationTh;
    }

    function getAbbreviationEn() {
        return $this->abbreviationEn;
    }

    function setRankId($rankId) {
        $this->rankId = $rankId;
    }

    function setRankNameTh($rankNameTh) {
        $this->rankNameTh = $rankNameTh;
    }

    function setRankNameEn($rankNameEn) {
        $this->rankNameEn = $rankNameEn;
    }

    function setAbbreviationTh($abbreviationTh) {
        $this->abbreviationTh = $abbreviationTh;
    }

    function setAbbreviationEn($abbreviationEn) {
        $this->abbreviationEn = $abbreviationEn;
    }


}
