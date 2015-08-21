<?php
namespace apps\test\interfaces;


/**
 * @name HelloService
 * @uri /hello
 * @description ทดสอบ
 */
interface IHelloService {
   
    /**
     * @name hello
     * @uri /hello
     * @param String name 
     * @return String hello
     * @description hello(name)
     * @authen true
     */ 
    public function hello($name);
    
    
        
    /**
     * @name add
     * @uri /add
     * @param int x
     * @param int y
     * @return int add
     * @description add(x,y)
     */
    public function add($x,$y);
    
    
     /**
     * @name customers
     * @uri /customers
     * @return List<Customer> customers
     * @description List Customers(JSON)
     * @sitemap true
     */ 
    public function customers(); 
    
    
    /**
     * @name addCustomer
     * @uri /cus/save
     * @param String name
     * @param String address
     * @return boolean result
     * @description Add Customer
     */ 
    public function addCustomer($name,$address); 
    
    /**
     * @name updateCustomer
     * @uri /cus/update
     * @param String id
     * @param String name
     * @return boolean result
     * @description Update Customer
     */ 
    public function updateCustomer($id,$name); 
    
    
     /**
     * @name delCustomer
     * @uri /cus/del
     * @param int id
     * @return boolean result
     * @description Delete Customer
     */ 
    public function delCustomer($id); 
    
    
    /**
     * @name view
     * @uri /view/hello
     * @description Hello API
     * @sitemap true
     */ 
    public function viewHello(); 
    
    /**
     * @name view
     * @uri /view
     * @description Customer List
     * @sitemap true
     */ 
    public function view(); 
    
     /**
     * @name viewadd
     * @uri /view/add
     * @description Add Customer
     * @sitemap true
     */ 
    public function viewAdd(); 
    
     /**
     * @name viewedit
     * @uri /view/edit
     * @param String id
     * @description Edit Customer
     */ 
    public function viewEdit($id); 
}
