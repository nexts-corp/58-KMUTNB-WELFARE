<?php
namespace apps\sdg\entity;
/**
     * @Entity
     * @Table(name="plugin_sendnewsust")
     */
class plugin_sendnewsust {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="SendNewUstID") */
    
       public $SendNewUstID;
       
        /**
        *@Column(type="string", name="SendNewsID") 
        */
       public $SendNewsID;
       
       /**
        *@Column(type="string", name="UsetypeID") 
        */
       public $UsetypeID;
       
       function getSendNewUstID() {
           return $this->SendNewUstID;
       }

       function getSendNewsID() {
           return $this->SendNewsID;
       }

       function getUsetypeID() {
           return $this->UsetypeID;
       }

       function setSendNewUstID($SendNewUstID) {
           $this->SendNewUstID = $SendNewUstID;
       }

       function setSendNewsID($SendNewsID) {
           $this->SendNewsID = $SendNewsID;
       }

       function setUsetypeID($UsetypeID) {
           $this->UsetypeID = $UsetypeID;
       }


}
