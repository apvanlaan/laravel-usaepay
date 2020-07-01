<?php

namespace Apvanlaan\UsaEpay\Transactions;
use Apvanlaan\UsaEpay\Epay;

class EpayCustomerAddress extends Epay
{
    
 	public String $company;
 	public String $firstname;
 	public String $lastname;
 	public String $street;
 	public String $street2;
 	public String $city;
 	public String $state;
 	public String $postalcode;
 	public String $country;
 	public String $phone;
 	public String $fax;   
}