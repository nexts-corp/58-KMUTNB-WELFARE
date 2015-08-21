<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="TitleName")
     */
class TitleName {
        /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="titleNameId") */
       public $titleNameId;
       
        /**
        *@Column(type="string" , length=255, name="titleNameTh") 
        */
       public $titleNameTh;
       
       /**
        *@Column(type="string" , length=255, name="titleNameEn") 
        */
       public $titleNameEn;
       
       function getTitleNameId() {
           return $this->titleNameId;
       }

       function getTitleNameTh() {
           return $this->titleNameTh;
       }

       function getTitleNameEn() {
           return $this->titleNameEn;
       }

       function setTitleNameId($titleNameId) {
           $this->titleNameId = $titleNameId;
       }

       function setTitleNameTh($titleNameTh) {
           $this->titleNameTh = $titleNameTh;
       }

       function setTitleNameEn($titleNameEn) {
           $this->titleNameEn = $titleNameEn;
       }




       
}
