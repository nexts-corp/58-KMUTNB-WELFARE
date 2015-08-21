<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="SendNews")
     */
class SendNews {
     /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="sendNewsId") */
       public $sendNewsId;
       
        /**
        *@Column(type="string", name="sendNewName") 
        */
       public $sendNewName;
       
       /**
        *@Column(type="string", name="sendNewsDetails") 
        */
       public $sendNewsDetails;
       
       /**
        *@Column(type="string", name="sendNewsFile") 
        */
       public $sendNewsFile;
       
       function getSendNewsID() {
           return $this->SendNewsID;
       }

       function getSendNewName() {
           return $this->SendNewName;
       }

       function getSendNewsDetails() {
           return $this->SendNewsDetails;
       }

       function getSendNewsFile() {
           return $this->SendNewsFile;
       }

       function setSendNewsID($SendNewsID) {
           $this->SendNewsID = $SendNewsID;
       }

       function setSendNewName($SendNewName) {
           $this->SendNewName = $SendNewName;
       }

       function setSendNewsDetails($SendNewsDetails) {
           $this->SendNewsDetails = $SendNewsDetails;
       }

       function setSendNewsFile($SendNewsFile) {
           $this->SendNewsFile = $SendNewsFile;
       }


}
