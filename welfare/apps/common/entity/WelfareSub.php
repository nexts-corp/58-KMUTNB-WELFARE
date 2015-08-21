<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="WelfareSub")
     */
class WelfareSub {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="welfareSubId") */
       public $welfareSubId;
       
       /**
        *  @Column(type="integer" , length=11, name="welfareId") 
        */
       public $welfareId;
       
        /**
        *@Column(type="string",length=255, name="welfareSubName") 
        */
       public $welfareSubName;
       /**
        *@Column(type="string", name="amount") 
        */
       public $amount;
       
       /**
        *@Column(type="string", name="welfareStart") 
        */
       public $welfareStart;
       
       /**
        *@Column(type="string", name="welfareEnd") 
        */
       public $welfareEnd;
       
       function getWelfareSubId() {
           return $this->welfareSubId;
       }

       function getWelfareId() {
           return $this->welfareId;
       }

       function getWelfareSubName() {
           return $this->welfareSubName;
       }

       function getAmount() {
           return $this->amount;
       }

       function getWelfareStart() {
           return $this->welfareStart;
       }

       function getWelfareEnd() {
           return $this->welfareEnd;
       }

       function setWelfareSubId($welfareSubId) {
           $this->welfareSubId = $welfareSubId;
       }

       function setWelfareId($welfareId) {
           $this->welfareId = $welfareId;
       }

       function setWelfareSubName($welfareSubName) {
           $this->welfareSubName = $welfareSubName;
       }

       function setAmount($amount) {
           $this->amount = $amount;
       }

       function setWelfareStart($welfareStart) {
           $this->welfareStart = $welfareStart;
       }

       function setWelfareEnd($welfareEnd) {
           $this->welfareEnd = $welfareEnd;
       }






}
