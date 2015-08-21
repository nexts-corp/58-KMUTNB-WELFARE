<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Welfare")
     */
class Welfare {
   /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="welfareId") */
       public $welfareId;
       
        /**
        *@Column(type="string", name="welfareName") 
        */
       public $welfareName;
       
        /**
        *@Column(type="string", name="welfareStart") 
        */
       public $welfareStart;
       
       /**
        *@Column(type="string", name="welfareEnd") 
        */
       public $welfareEnd;
       
       function getWelfareId() {
           return $this->welfareId;
       }

       function getWelfareName() {
           return $this->welfareName;
       }

       function getWelfareStart() {
           return $this->welfareStart;
       }

       function getWelfareEnd() {
           return $this->welfareEnd;
       }

       function setWelfareId($welfareId) {
           $this->welfareId = $welfareId;
       }

       function setWelfareName($welfareName) {
           $this->welfareName = $welfareName;
       }

       function setWelfareStart($welfareStart) {
           $this->welfareStart = $welfareStart;
       }

       function setWelfareEnd($welfareEnd) {
           $this->welfareEnd = $welfareEnd;
       }


}
