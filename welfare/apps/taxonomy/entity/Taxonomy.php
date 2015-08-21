<?php

namespace apps\taxonomy\entity;

/**
 * Description of Taxonomy
 *
 * @author tawatchai
 */

/**
 * @Entity
 * @Table(name="Taxonomy")
 */
class Taxonomy {
    /**
     * @Id
     * @Column(type="string" , length=10, name="code") */
    public $code;
    
    /**
     * @Column(type="string", length=10, name="parentCode") 
     */
    public $parentCode;
    
    /**
     * @Column(type="string", length=255, name="value") 
     */
    public $value;
    
    /**
     * @Column(type="string", length=255, name="option1",nullable=true) 
     */
    public $option1;
    
    /**
     * @Column(type="string", length=255, name="option2",nullable=true) 
     */
    public $option2;
    
    /**
     * @Column(type="string", length=255, name="option3",nullable=true) 
     */
    public $option3;

}
