<?php

namespace Apvanlaan\UsaEpay\Transactions;
use Apvanlaan\UsaEpay\Epay;

class EpayAmountDetail extends Epay
{
    public Double $subtotal;
    public Double $tax;
    public Boolean $nontaxable;
    public Double $tip;
    public Double $discount;
    public Double $shipping;
    public Double $duty;
    public Boolean $enable_partialauth;    
}