<?php

namespace Apvanlaan\UsaEpay\Transactions;
use Apvanlaan\UsaEpay\Epay;

class EpayLineItem extends Epay
{
    
 	public String $product_key;
 	public String $name;
 	public Double $cost;
 	public Integer $qty;
 	public String $description;
 	public String $sku;
 	public Boolean $taxable;
 	public Double $tax_amount;
 	public String $tax_rate;
 	public String $discount_rate;
 	public Double $discount_amount;
 	public String $location_key;
 	public String $commodity_code;

}