<?php
namespace apps\welfare\entity;
/**
     * @Entity
     * @Table(name="EmployeeRight")
     */
class EmployeeRight {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="employeeRightId") */
       public $employeeRightId;
       
        /**
        *@Column(type="integer", name="conditionId") 
        */
       public $conditionId;
       
        /**
        *@Column(type="integer", name="employeeTypeId") 
        */
       public $employeeTypeId;
       
       function getEmployeeRightId() {
           return $this->employeeRightId;
       }

       function getConditionId() {
           return $this->conditionId;
       }

       function getEmployeeTypeId() {
           return $this->employeeTypeId;
       }

       function setEmployeeRightId($employeeRightId) {
           $this->employeeRightId = $employeeRightId;
       }

       function setConditionId($conditionId) {
           $this->conditionId = $conditionId;
       }

       function setEmployeeTypeId($employeeTypeId) {
           $this->employeeTypeId = $employeeTypeId;
       }


}
