<?php

namespace Apvanlaan\UsaEpay\Transactions;
use Apvanlaan\UsaEpay\Epay;

class EpayTrait extends Epay
{
    public Bool $is_debt;
    public Bool $is_bill_pay;
    public Bool $is_recurring;
    public Bool $is_healthcare;
    public Bool $is_cash_advance;
    public Int $secure_collection;
    
}