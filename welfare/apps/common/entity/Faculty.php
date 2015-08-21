<?php

namespace apps\common\entity;

use th\co\bpg\cde\collection\CJEntity;

/**
 * @Entity
 * @Table(name="Faculty")
 */
class Faculty {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="facultyId") */
    public $facultyId;

    /**
     * @Column(type="string" , length=255, name="facultyCode") 
     */
    public $facultyCode;

    /**
     * @Column(type="string" , length=255, name="campusId") 
     */
    public $campusId;

    /**
     * @Column(type="string" , length=255, name="facultyNameTh") 
     */
    public $facultyNameTh;

    /**
     * @Column(type="string" , length=255, name="facultyNameEn") 
     */
    public $facultyNameEn;

    function getFacultyId() {
        return $this->facultyId;
    }

    function getFacultyCode() {
        return $this->facultyCode;
    }

    function getCampusId() {
        return $this->campusId;
    }

    function getFacultyNameTh() {
        return $this->facultyNameTh;
    }

    function getFacultyNameEn() {
        return $this->facultyNameEn;
    }

    function setFacultyId($facultyId) {
        $this->facultyId = $facultyId;
    }

    function setFacultyCode($facultyCode) {
        $this->facultyCode = $facultyCode;
    }

    function setCampusId($campusId) {
        $this->campusId = $campusId;
    }

    function setFacultyNameTh($facultyNameTh) {
        $this->facultyNameTh = $facultyNameTh;
    }

    function setFacultyNameEn($facultyNameEn) {
        $this->facultyNameEn = $facultyNameEn;
    }

}
