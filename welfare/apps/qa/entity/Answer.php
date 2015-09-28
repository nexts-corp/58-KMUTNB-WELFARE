<?php
namespace apps\qa\entity;
use apps\common\entity\EntityBase;
/**
     * @Entity
     * @Table(name="Answer")
     */
class Answer extends EntityBase {
     /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="answerId") */
       public $answerId;
       
        /**
        *@Column(type="string", name="questionsId") 
        */
       public $questionsId;
       
       /**
        *@Column(type="text", name="answerDetails") 
        */
       public $answerDetails;
       
       
       public $multiFileName;
       
   
       function getAnswerId() {
           return $this->answerId;
       }

       function getQuestionsId() {
           return $this->questionsId;
       }

       function getAnswerDetails() {
           return $this->answerDetails;
       }

       function getMultiFileName() {
           return $this->multiFileName;
       }

       function setAnswerId($answerId) {
           $this->answerId = $answerId;
       }

       function setQuestionsId($questionsId) {
           $this->questionsId = $questionsId;
       }

       function setAnswerDetails($answerDetails) {
           $this->answerDetails = $answerDetails;
       }

       function setMultiFileName($multiFileName) {
           $this->multiFileName = $multiFileName;
       }


      

}
