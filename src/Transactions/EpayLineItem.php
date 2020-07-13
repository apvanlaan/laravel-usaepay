<?php

namespace Apvanlaan\UsaEpay\Transactions;

use Apvanlaan\UsaEpay\Epay;

class EpayLineItem extends Epay
{
    public String $product_key;
    public String $name;
    public Float $cost;
    public Int $qty;
    public String $description;
    public String $sku;
    public Bool $taxable;
    public Float $tax_amount;
    public String $tax_rate;
    public String $discount_rate;
    public Float $discount_amount;
    public String $location_key;
    public String $commodity_code;
}
