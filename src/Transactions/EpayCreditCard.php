<?php

namespace Apvanlaan\UsaEpay\Transactions;

use Apvanlaan\UsaEpay\Epay;

class EpayCreditCard extends Epay
{
    public String $cardholder;
    public String $number;
    public String $expiration;
    public Int $cvc;
    public String $avs_street;
    public String $avs_postalcode;
}
