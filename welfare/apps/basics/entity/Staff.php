<?php

namespace apps\basics\entity;

/**
 * @Entity
 * @Table(name="staff")
 */
class Staff {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="staffId") */
    public $staffId;

    /**
     * @Column(type="string" , length=255, name="staffNameTh") 
     */
    public $staffNameTh;

    /**
     * @Column(type="string" , length=255, name="staffNameEn") 
     */
    public $staffNameEn;
    
    function getStaffId() {
        return $this->staffId;
    }

    function getStaffNameTh() {
        return $this->staffNameTh;
    }

    function getStaffNameEn() {
        return $this->staffNameEn;
    }

    function setStaffId($staffId) {
        $this->staffId = $staffId;
    }

    function setStaffNameTh($staffNameTh) {
        $this->staffNameTh = $staffNameTh;
    }

    function setStaffNameEn($staffNameEn) {
        $this->staffNameEn = $staffNameEn;
    }


}
