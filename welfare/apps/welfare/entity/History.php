<?php

namespace apps\welfare\entity;

/**
 * @Entity
 * @Table(name="WelfareHistory")
 */
class History {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="historyId") */
    public $historyId;

    /**
     * @Column(type="integer",length=11, name="rightId")
     */
    public $rightId;

    /**
     * @Column(type="date", name="dateUse",nullable=true)
     */
    public $dateUse;
    
   /**
     * @Column(type="date", name="amount",nullable=true)
     */
    public $amount;
    

}
