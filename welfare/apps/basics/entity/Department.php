<?php

namespace apps\basics\entity;
/**
     * @Entity
     * @Table(name="Department")
     */
class Department {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="departmentId") */
       public $departmentId;
       
        /**
        *@Column(type="string" , length=255, name="facultyId") 
        */
       public $facultyId;
       
        /**
        *@Column(type="string" , length=20, name="departmentCode") 
        */
       public $departmentCode;
       
       /**
        *@Column(type="string" , length=255, name="departmentNameTh") 
        */
       public $departmentNameTh;
       
       /**
        *@Column(type="string" , length=255, name="departmentNameEn") 
        */
       public $departmentNameEn;
       
       function getDepartmentId() {
           return $this->departmentId;
       }

       function getFacultyId() {
           return $this->facultyId;
       }

       function getDepartmentCode() {
           return $this->departmentCode;
       }

       function getDepartmentName() {
           return $this->departmentName;
       }

       function getDepartmentNameEn() {
           return $this->departmentNameEn;
       }

       function setDepartmentId($departmentId) {
           $this->departmentId = $departmentId;
       }

       function setFacultyId($facultyId) {
           $this->facultyId = $facultyId;
       }

       function setDepartmentCode($departmentCode) {
           $this->departmentCode = $departmentCode;
       }

       function setDepartmentName($departmentName) {
           $this->departmentName = $departmentName;
       }

       function setDepartmentNameEn($departmentNameEn) {
           $this->departmentNameEn = $departmentNameEn;
       }




}
