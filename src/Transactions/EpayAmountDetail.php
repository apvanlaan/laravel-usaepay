<?php

namespace Apvanlaan\UsaEpay\Transactions;

use Apvanlaan\UsaEpay\Epay;

class EpayAmountDetail extends Epay
{
    public Float $subtotal;
    public Float $tax;
    public Bool $nontaxable;
    public Float $tip;
    public Float $discount;
    public Float $shipping;
    public Float $duty;
    public Bool $enable_partialauth;
}
