<?php

namespace apps\common\entity;
use th\co\bpg\cde\collection\CJEntity ;
/**
 * @Entity
 * @Table(name="AcademicPositions")
 */
class AcademicPositions  {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="academicPositionsId") */
    public $academicPositionsId;

    /**
     * @Column(type="string" , length=255, name="academicPositionsNameTh") 
     */
    public $academicPositionsNameTh;

    /**
     * @Column(type="string" , length=255, name="academicPositionsNameEn") 
     */
    public $academicPositionsNameEn;

    /**
     * @Column(type="string" , length=255, name="abbreviationTh") 
     */
    public $abbreviationTh;

    /**
     * @Column(type="string" , length=255, name="abbreviationEn") 
     */
    public $abbreviationEn;

   

    function getAcademicPositionsId() {
        return $this->academicPositionsId;
    }

    function getAcademicPositionsName() {
        return $this->academicPositionsName;
    }

    function getAcademicPositionsNameEn() {
        return $this->academicPositionsNameEn;
    }

    function getAbbreviationTh() {
        return $this->abbreviationTh;
    }

    function getAbbreviationEn() {
        return $this->abbreviationEn;
    }

    
    function setAcademicPositionsId($academicPositionsId) {
        $this->academicPositionsId = $academicPositionsId;
    }

    function setAcademicPositionsNameTh($academicPositionsNameTh) {
        $this->academicPositionsNameTh = $academicPositionsNameTh;
    }

    function setAcademicPositionsNameEn($academicPositionsNameEn) {
        $this->academicPositionsNameEn = $academicPositionsNameEn;
    }

    function setAbbreviationTh($abbreviationTh) {
        $this->abbreviationTh = $abbreviationTh;
    }

    function setAbbreviationEn($abbreviationEn) {
        $this->abbreviationEn = $abbreviationEn;
    }

   
}
