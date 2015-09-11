<?php

namespace apps\taxonomy\entity;

use apps\common\entity\EntityBase;

/**
 * Description of Taxonomy
 *
 * @author tawatchai
 */

/**
 * @Entity
 * @Table(name="Taxonomy")
 */
class Taxonomy extends EntityBase {

    /**
     * @Id
     * @Column(type="string" , length=10, name="id") 
     */
    public $id;

    /**
     * @Column(type="string", length=10, name="parentId") 
     */
    public $parentId;

    /**
     * @Column(type="string", length=1, name="parent",nullable=true) 
     */
    public $parent;

    /**
     * @Column(type="string", length=255, name="pCode",nullable=true) 
     */
    public $pCode;

    /**
     * @Column(type="string", length=255, name="code",nullable=true) 
     */
    public $code;

    /**
     * @Column(type="string", length=255, name="value1",nullable=true) 
     */
    public $value1;

    /**
     * @Column(type="string", length=255, name="value2",nullable=true) 
     */
    public $value2;

    /**
     * @Column(type="string", length=255, name="optional",nullable=true) 
     */
    public $optional;

}
