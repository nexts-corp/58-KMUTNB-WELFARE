<?php

namespace apps\welfare\entity;
use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="WelfareHistory")
 */
class History extends EntityBase{

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="historyId") */
    public $historyId;

    /**
     * @Column(type="integer",length=11, name="conditionsId")
     */
    public $conditionsId;
    
     /**
     * @Column(type="integer",length=11, name="welfareId")
     */
    public $welfareId;
    
       /**
     * @Column(type="integer",length=11, name="memberId")
     */
    public $memberId;

    /**
     * @Column(type="date", name="dateUse",nullable=true)
     */
    public $dateUse;
    
   /**
     * @Column(type="date", name="amount",nullable=true)
     */
    public $amount;
    

}
