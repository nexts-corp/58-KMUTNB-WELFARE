<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Privileges")
     */
class Privileges {
   /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="privilegeId") */
       public $privilegeId;
       
        /**
        *@Column(type="string",length=255, name="registerId") 
        */
       public $registerId;
       
        /**
        *@Column(type="string",length=255, name="familyId") 
        */
       public $familyId;
       
        /**
        *@Column(type="string",length=255, name="ratio") 
        */
       public $ratio;
       
       function getPrivilegeId() {
           return $this->privilegeId;
       }

       function getRegisterId() {
           return $this->registerId;
       }

       function getFamilyId() {
           return $this->familyId;
       }

       function getRatio() {
           return $this->ratio;
       }

       function setPrivilegeId($privilegeId) {
           $this->privilegeId = $privilegeId;
       }

       function setRegisterId($registerId) {
           $this->registerId = $registerId;
       }

       function setFamilyId($familyId) {
           $this->familyId = $familyId;
       }

       function setRatio($ratio) {
           $this->ratio = $ratio;
       }




       
      




       
       
       
       


       
}
