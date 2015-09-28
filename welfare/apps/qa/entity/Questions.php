<?php
namespace apps\qa\entity;
use apps\common\entity\EntityBase;
/**
     * @Entity
     * @Table(name="Questions")
     */
class Questions extends EntityBase {
     /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="questionsId") */
       public $questionsId;
       
        /**
        *@Column(type="string", name="questionsName") 
        */
       public $questionsName;
       
       /**
        *@Column(type="text", name="questionsDetails") 
        */
       public $questionsDetails;
      
       function getQuestionsId() {
           return $this->questionsId;
       }

       function getQuestionsName() {
           return $this->questionsName;
       }

       function getQuestionsDetails() {
           return $this->questionsDetails;
       }

       function setQuestionsId($questionsId) {
           $this->questionsId = $questionsId;
       }

       function setQuestionsName($questionsName) {
           $this->questionsName = $questionsName;
       }

       function setQuestionsDetails($questionsDetails) {
           $this->questionsDetails = $questionsDetails;
       }


      
  
    



}
