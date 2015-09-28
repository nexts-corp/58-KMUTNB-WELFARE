<?php
namespace apps\news\entity;
use apps\common\entity\EntityBase;
/**
     * @Entity
     * @Table(name="News")
     */
class News extends EntityBase {
     /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="newsId") */
       public $newsId;
       
        /**
        *@Column(type="string", name="newsName") 
        */
       public $newsName;
       
       /**
        *@Column(type="text", name="newsDetails") 
        */
       public $newsDetails;
       
        /**
        *@Column(type="string", name="employeeTypeId") 
        */
       
       public $employeeTypeId;
      
       public $multiFileName;
       
       function getMultiFileName() {
           return $this->multiFileName;
       }

       function setMultiFileName($multiFileName) {
           $this->multiFileName = $multiFileName;
       }

              function getNewsId() {
           return $this->newsId;
       }

       function getNewsName() {
           return $this->newsName;
       }

       function getNewsDetails() {
           return $this->newsDetails;
       }

       function getEmployeeType() {
           return $this->employeeType;
       }

       function setNewsId($newsId) {
           $this->newsId = $newsId;
       }

       function setNewsName($newsName) {
           $this->newsName = $newsName;
       }

       function setNewsDetails($newsDetails) {
           $this->newsDetails = $newsDetails;
       }

       function setEmployeeType($employeeType) {
           $this->employeeType = $employeeType;
       }


}
