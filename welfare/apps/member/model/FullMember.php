<?php

namespace apps\member\model;

/**
 * @Entity
 * @Table(name="v_fullmember")
 */
class FullMember {

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
     * @Column(type="string", length=255, name="gender1",nullable=true) 
     */
    public $gender1;

    /**
     * @Column(type="string", length=255, name="gender2",nullable=true) 
     */
    public $gender2;

    /**
     * @Column(type="string", length=10, name="titleNameId",nullable=true) 
     */
    public $titleNameId;

    /**
     * @Column(type="string", length=255, name="titleName1",nullable=true) 
     */
    public $titleName1;

    /**
     * @Column(type="string", length=255, name="titleName2",nullable=true) 
     */
    public $titleName2;

    /**
     * @Column(type="string", length=10, name="academicId",nullable=true) 
     */
    public $academicId;

    /**
     * @Column(type="string", length=255, name="academic1",nullable=true) 
     */
    public $academic1;

    /**
     * @Column(type="string", length=255, name="academic2",nullable=true) 
     */
    public $academic2;
    
        /**
     * @Column(type="string", length=255, name="titles1",nullable=true) 
     */
    public $titles1;

    /**
     * @Column(type="string", length=255, name="titles2",nullable=true) 
     */
    public $titles2;

    /**
     * @Column(type="string", length=255, name="fname",nullable=true) 
     */
    public $fname;

    /**
     * @Column(type="string", length=255, name="lname",nullable=true) 
     */
    public $lname;

    /**
     * @Column(type="string", name="dob") 
     */
    public $dob;

    /**
     * @Column(type="string", length=13, name="employeeCode",nullable=true) 
     */
    public $employeeCode;

    /**
     * @Column(type="string",  name="workStartDate") 
     */
    public $workStartDate;

    /**
     * @Column(type="string",  name="workEndDate" ,nullable=true) 
     */
    public $workEndDate;

    /**
     * @Column(type="string", length=10, name="memberActiveId",nullable=true) 
     */
    public $memberActiveId;

    /**
     * @Column(type="string", length=255, name="memberActive1",nullable=true) 
     */
    public $memberActive1;

    /**
     * @Column(type="string", length=255, name="memberActive2",nullable=true) 
     */
    public $memberActive2;
    
    /**
     * @Column(type="string", length=10, name="userTypeId",nullable=true) 
     */
    public $userTypeId;

    /**
     * @Column(type="string", length=255, name="userType1",nullable=true) 
     */
    public $userType1;

    /**
     * @Column(type="string", length=255, name="userType2",nullable=true) 
     */
    public $userType2;

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
     * @Column(type="string", length=255, name="emailUniversity",nullable=true) 
     */
    public $emailUniversity;

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
     * @Column(type="string", name="salaryDate",nullable=true) 
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
     * @Column(type="string", length=255, name="employeeType1",nullable=true) 
     */
    public $employeeType1;

    /**
     * @Column(type="string", length=255, name="employeeType2",nullable=true) 
     */
    public $employeeType2;

    /**
     * @Column(type="string", length=10, name="facultyId",nullable=true) 
     */
    public $facultyId;

    /**
     * @Column(type="string", length=255, name="faculty1",nullable=true) 
     */
    public $faculty1;

    /**
     * @Column(type="string", length=255, name="faculty2",nullable=true) 
     */
    public $faculty2;

    /**
     * @Column(type="string", length=10, name="departmentId",nullable=true) 
     */
    public $departmentId;

    /**
     * @Column(type="string", length=255, name="department1",nullable=true) 
     */
    public $department1;

    /**
     * @Column(type="string", length=255, name="department2",nullable=true) 
     */
    public $department2;

    /**
     * @Column(type="string", length=10, name="positionId",nullable=true) 
     */
    public $positionId;

    /**
     * @Column(type="string", length=255, name="position1",nullable=true) 
     */
    public $position1;

    /**
     * @Column(type="string", length=255, name="position2",nullable=true) 
     */
    public $position2;

    /**
     * @Column(type="string", length=10, name="matierId",nullable=true) 
     */
    public $matierId;

    /**
     * @Column(type="string", length=255, name="matier1",nullable=true) 
     */
    public $matier1;

    /**
     * @Column(type="string", length=255, name="matier2",nullable=true) 
     */
    public $matier2;

}
