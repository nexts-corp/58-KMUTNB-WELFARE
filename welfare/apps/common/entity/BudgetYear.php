<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="BudgetYear")
     */
class budgetYear {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="budgetYearId") */
       public $budgetYearId;
       
        /**
        *@Column(type="string" , length=255, name="budgetYearBhd") 
        */
       public $budgetYearBhd;
       
        /**
        *@Column(type="string" , length=255, name="budgetYearStart") 
        */
       public $budgetYearStart;
       
       /**
        *@Column(type="string" , length=255, name="budgetYearEnd") 
        */
       public $budgetYearEnd;
       
       function getBudgetYearId() {
           return $this->budgetYearId;
       }

       function getBudgetYearBhd() {
           return $this->budgetYearBhd;
       }

       function getBudgetYearStart() {
           return $this->budgetYearStart;
       }

       function getBudgetYearEnd() {
           return $this->budgetYearEnd;
       }

       function setBudgetYearId($budgetYearId) {
           $this->budgetYearId = $budgetYearId;
       }

       function setBudgetYearBhd($budgetYearBhd) {
           $this->budgetYearBhd = $budgetYearBhd;
       }

       function setBudgetYearStart($budgetYearStart) {
           $this->budgetYearStart = $budgetYearStart;
       }

       function setBudgetYearEnd($budgetYearEnd) {
           $this->budgetYearEnd = $budgetYearEnd;
       }




}
