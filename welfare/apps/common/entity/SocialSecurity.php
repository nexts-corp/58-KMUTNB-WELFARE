<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="SocialSecurity")
     */
class SocialSecurity {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="socialSecurityId") */
       public $socialSecurityId;
       
        /**
        *@Column(type="string", name="registerId") 
        */
       public $registerId;
       
       /**
        *@Column(type="string", name="DateStart") 
        */
       public $DateStart;
       
       /**
        *@Column(type="string", name="hospitalPrivileges") 
        */
       public $hospitalPrivileges;
       
       /**
        *@Column(type="date", name="dateEnd") 
        */
       public $dateEnd;
       
       function getSocialSecurityId() {
           return $this->socialSecurityId;
       }

       function getRegisterId() {
           return $this->registerId;
       }

       function getDateStart() {
           return $this->DateStart;
       }

       function getHospitalPrivileges() {
           return $this->hospitalPrivileges;
       }

       function getDateEnd() {
           return $this->dateEnd;
       }

       function setSocialSecurityId($socialSecurityId) {
           $this->socialSecurityId = $socialSecurityId;
       }

       function setRegisterId($registerId) {
           $this->registerId = $registerId;
       }

       function setDateStart($DateStart) {
           $this->DateStart = $DateStart;
       }

       function setHospitalPrivileges($hospitalPrivileges) {
           $this->hospitalPrivileges = $hospitalPrivileges;
       }

       function setDateEnd($dateEnd) {
           $this->dateEnd = $dateEnd;
       }



}
