<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="Month")
     */
class Month {
     /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="monthId") */
       public $monthId;
       
       /**
        *@Column(type="string",length=255, name="month") 
        */
       public $month;
       function getMonthId() {
           return $this->monthId;
       }

       function getMonth() {
           return $this->month;
       }

       function setMonthId($monthId) {
           $this->monthId = $monthId;
       }

       function setMonth($month) {
           $this->month = $month;
       }


       
       
}
