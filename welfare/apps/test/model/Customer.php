<?php

namespace apps\test\model;


/**
 * @Entity
 * @Table(name="av_customer")
 */
class Customer {
    
    
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer", length=11, name="cus_id") 
     */
    public $id;
    
    /** @Column(type="string", length=255, name="cus_name") */
    public $name;
    
    /** @Column(type="string", length=255, name="cus_address") */
    public $address;
   
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getAddress() {
        return $this->address;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAddress($address) {
        $this->address = $address;
    }



}
