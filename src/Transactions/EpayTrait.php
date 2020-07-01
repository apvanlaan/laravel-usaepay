<?php

namespace Apvanlaan\UsaEpay\Transactions;
use Apvanlaan\UsaEpay\Epay;

class EpayTrait extends Epay
{
    public Boolean $is_debt;
    public Boolean $is_bill_pay;
    public Boolean $is_recurring;
    public Boolean $is_healthcare;
    public Boolean $is_cash_advance;
    public Integer $secure_collection;
    
}