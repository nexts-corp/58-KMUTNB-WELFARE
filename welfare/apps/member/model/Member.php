<?php

namespace apps\member\model;

/**
 * @Entity
 * @Table(name="v_member")
 */
class Member {

    /**
     * @Id
     * @Column(type="integer" , length=11, name="memberId") */
    public $memberId;

    /**
     * @Column(type="string", length=13, name="idCard",nullable=true) 
     */
    public $idCard;

    /**
     * @Column(type="string", length=10, name="genderId",nullable=true) 
     */
    public $genderId;

    /**
     * @Column(type="string", length=10, name="titleNameId",nullable=true) 
     */
    public $titleNameId;

    /**
     * @Column(type="string", length=10, name="academicId",nullable=true) 
     */
    public $academicId;

    /**
     * @Column(type="string", length=255, name="fname",nullable=true) 
     */
    public $fname;

    /**
     * @Column(type="string", length=255, name="lname",nullable=true) 
     */
    public $lname;

    /**
     * @Column(type="date", name="dob") 
     */
    public $dob;

    /**
     * @Column(type="string", length=13, name="employeeCode",nullable=true) 
     */
    public $employeeCode;

    /**
     * @Column(type="date",  name="workStartDate") 
     */
    public $workStartDate;

    /**
     * @Column(type="date",  name="workEndDate" ,nullable=true) 
     */
    public $workEndDate;

    /**
     * @Column(type="string", length=10, name="memberActiveId",nullable=true) 
     */
    public $memberActiveId;

    /**
     * @Column(type="integer" , length=11, name="contactId") 
     */
    public $contactId;

    /**
     * @Column(type="string", length=255, name="address",nullable=true) 
     */
    public $address;

    /**
     * @Column(type="string", length=255, name="internalPhone",nullable=true) 
     */
    public $internalPhone;

    /**
     * @Column(type="string", length=255, name="phone",nullable=true) 
     */
    public $phone;

    /**
     * @Column(type="string", length=255, name="mobile",nullable=true) 
     */
    public $mobile;

    /**
     * @Column(type="string", length=255, name="email",nullable=true) 
     */
    public $email;

    /**
     * @Column(type="integer" , length=11, name="salaryId") 
     */
    public $salaryId;

    

    /**
     * @Column(type="string", length=255, name="rank",nullable=true) 
     */
    public $rank;

    /**
     * @Column(type="float", name="salary",nullable=true) 
     */
    public $salary;

    /**
     * @Column(type="date", name="salaryDate",nullable=true) 
     */
    public $salaryDate;
      /**
     * @Column(type="integer" , length=11, name="workId") 
     */
    public $workId;

    
    /**
     * @Column(type="string", length=10, name="employeeTypeId",nullable=true) 
     */
    public $employeeTypeId;

    /**
     * @Column(type="string", length=10, name="facultyId",nullable=true) 
     */
    public $facultyId;

    /**
     * @Column(type="string", length=10, name="departmentId",nullable=true) 
     */
    public $departmentId;

    /**
     * @Column(type="string", length=10, name="positionId",nullable=true) 
     */
    public $positionId;

    /**
     * @Column(type="string", length=10, name="matierId",nullable=true) 
     */
    public $matierId;

}
