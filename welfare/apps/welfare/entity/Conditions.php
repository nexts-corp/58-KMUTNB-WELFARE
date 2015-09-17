<?php

namespace apps\welfare\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="WelfareConditions")
 */
class Conditions extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="conditionsId") */
    public $conditionsId;

    /**
     * @Column(type="integer",length=11, name="welfareId")
     */
    public $welfareId;

    /**
     * @Column(type="integer",length=11, name="detailsId")
     */
    public $detailsId;

    /**
     * @Column(type="string", name="fieldMap",length=100,nullable=true)
     */
    public $fieldMap;

    /**
     * @Column(type="string", name="operations",length=10,nullable=true)
     */
    public $operations;

    /**
     * @Column(type="string", name="valuex",length=20,nullable=true)
     */
    public $valuex;

    function getConditionsId() {
        return $this->conditionsId;
    }

    function getWelfareId() {
        return $this->welfareId;
    }

    function getDetailsId() {
        return $this->detailsId;
    }

    function getFieldMap() {
        return $this->fieldMap;
    }

    function getOperations() {
        return $this->operations;
    }

    function getValuex() {
        return $this->valuex;
    }

    function setConditionsId($conditionsId) {
        $this->conditionsId = $conditionsId;
    }

    function setWelfareId($welfareId) {
        $this->welfareId = $welfareId;
    }

    function setDetailsId($detailsId) {
        $this->detailsId = $detailsId;
    }

    function setFieldMap($fieldMap) {
        $this->fieldMap = $fieldMap;
    }

    function setOperations($operations) {
        $this->operations = $operations;
    }

    function setValuex($valuex) {
        $this->valuex = $valuex;
    }

}
