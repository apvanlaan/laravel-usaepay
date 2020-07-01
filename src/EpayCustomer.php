<?php

namespace Apvanlaan\UsaEpay;
// use Apvanlaan\UsaEpay\UsaEpay;
use Apvanlaan\UsaEpay\Epay;

class EpayCustomer extends Epay
{
    public String $company;
    public String $first_name;
    public String $last_name;
    public String $customerid;
    public String $street;
    public $street2;
    public String $city;
    public String $state;
    public String $postalcode;
    public String $country;
    public String $phone;
    public String $fax;
    public String $email;
    public String $url;
    public String $notes;
    public String $description;
    public String $custkey;
    
   
    /**
     * [listCustomers description]
     * @return [type] [description]
     */
    public function listCustomers(){
    	
    	// $epay = new UsaEpay();
    	$res = $this->epay->list("/customers");
    	return $res;
    }
    /**
     * [getCustomer description]
     * @return [type] [description]
     */
    public function getCustomer(){

        $required = ['custkey'];

        $validated = $this->validate($required);
        
        if($validated){
        	$customer = $this;
        	
        	$res = $this->epay->get("/customers/" . $customer->custkey,$customer);
        	return $res;
        }else{
            return "validation error";
        }
    }
    /**
     * [addCustomer description]
     */
    public function addCustomer(){
        $required = [];
        if(!isset($this->company)){
            array_push($required, 'first_name');
            array_push($required, 'last_name');
        }
        if(!isset($this->first_name) || !isset($this->last_name)){
            array_push($required,'company');
        }
        $validated = $this->validate($required);
        if($validated){
           
        	$customer = $this;
        	$res = $this->epay->post("/customers",$customer);
        	
        	return $res;
        }else{
            return "validation error";
        }
    }
    /**
     * [updateCustomer description]
     * @return [type] [description]
     */
    public function updateCustomer(){
        $required = ['custkey'];

        $validated = $this->validate($required);
        
        if($validated){
            $res = $this->epay->put("/customers/" . $customer->custkey,$customer);

            return $res;    
        }else{
            return "validation error";
        }
        
    }
    /**
     * [deleteCustomer description]
     * @return [type] [description]
     */
    public function deleteCustomer(){
        $required = ['custkey'];

        $validated = $this->validate($required);
        if($validated){
            $customer = $this;
        
            $res = $this->epay->delete("/customers/" . $customer->custkey,$customer);
            return $res;
        }else{
            return "validation error";
        }
    	
    }
    

}