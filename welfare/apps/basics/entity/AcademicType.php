<?php

namespace apps\basics\entity;

use th\co\bpg\cde\collection\CJEntity;

/**
 * @Entity
 * @Table(name="AcademicType")
 */
class AcademicType {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="academicTypeId") */
    public $academicTypeId;

    /**
     * @Column(type="string" , length=255, name="academicTypeTh",nullable=true) 
     */
    public $academicTypeTh;

    /**
     * @Column(type="string" , length=255, name="academicTypeEn",nullable=true) 
     */
    public $academicTypeEn;

    /**
     * @Column(type="string" , length=255, name="abbreviationTh",nullable=true) 
     */
    public $abbreviationTh;

    /**
     * @Column(type="string" , length=255, name="abbreviationEn",nullable=true) 
     */
    public $abbreviationEn;
    
    function getAcademicTypeId() {
        return $this->academicTypeId;
    }

    function getAcademicTypeTh() {
        return $this->academicTypeTh;
    }

    function getAcademicTypeEn() {
        return $this->academicTypeEn;
    }

    function getAbbreviationTh() {
        return $this->abbreviationTh;
    }

    function getAbbreviationEn() {
        return $this->abbreviationEn;
    }

    function setAcademicTypeId($academicTypeId) {
        $this->academicTypeId = $academicTypeId;
    }

    function setAcademicTypeTh($academicTypeTh) {
        $this->academicTypeTh = $academicTypeTh;
    }

    function setAcademicTypeEn($academicTypeEn) {
        $this->academicTypeEn = $academicTypeEn;
    }

    function setAbbreviationTh($abbreviationTh) {
        $this->abbreviationTh = $abbreviationTh;
    }

    function setAbbreviationEn($abbreviationEn) {
        $this->abbreviationEn = $abbreviationEn;
    }


}
