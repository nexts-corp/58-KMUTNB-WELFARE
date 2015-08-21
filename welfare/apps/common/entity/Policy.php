<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Policy")
     */
class Policy {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="policyId") */
       public $policyId;
       
       /**
        *@Column(type="string",length=255, name="policyname") 
        */
       public $policyname;
       
       /**
        *@Column(type="string",length=255, name="policydetail") 
        */
       public $policydetail;
       
       function getPolicyId() {
           return $this->policyId;
       }

       function getPolicyname() {
           return $this->policyname;
       }

       function getPolicydetail() {
           return $this->policydetail;
       }

       function setPolicyId($policyId) {
           $this->policyId = $policyId;
       }

       function setPolicyname($policyname) {
           $this->policyname = $policyname;
       }

       function setPolicydetail($policydetail) {
           $this->policydetail = $policydetail;
       }


       
}
