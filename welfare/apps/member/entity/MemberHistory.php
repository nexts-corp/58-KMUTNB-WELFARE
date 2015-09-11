<?php

namespace apps\member\entity;

use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="MemberHistory")
 */
class MemberHistory extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="historyId") */
    public $historyId;

    /**
     * @Column(type="integer", length=11, name="memberId",nullable=true) 
     */
    public $memberId;

    /**
     * @Column(type="string", length=100, name="fieldChange",nullable=true) 
     */
    public $fieldChange;

    /**
     * @Column(type="string", length=255, name="valueOld",nullable=true) 
     */
    public $valueOld;

    /**
     * @Column(type="string", length=255, name="valueNew",nullable=true) 
     */
    public $valueNew;

}
