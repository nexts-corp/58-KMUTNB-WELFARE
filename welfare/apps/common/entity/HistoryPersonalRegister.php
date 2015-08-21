<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="plugin_titlename")
     */
class titlename {
        /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="TitleNameID") */
       public $TitleNameID;
       
        /**
        *@Column(type="string" , length=255, name="TitleName") 
        */
       public $TitleName;
       
       /**
        *@Column(type="string" , length=255, name="TitleNameEn") 
        */
       public $TitleNameEn;
       
       function getTitleNameID() {
           return $this->TitleNameID;
       }

       function getTitleName() {
           return $this->TitleName;
       }

       function getTitleNameEn() {
           return $this->TitleNameEn;
       }

       function setTitleNameID($TitleNameID) {
           $this->TitleNameID = $TitleNameID;
       }

       function setTitleName($TitleName) {
           $this->TitleName = $TitleName;
       }

       function setTitleNameEn($TitleNameEn) {
           $this->TitleNameEn = $TitleNameEn;
       }




       
}
