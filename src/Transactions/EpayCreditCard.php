<?php

namespace Apvanlaan\UsaEpay\Transactions;
use Apvanlaan\UsaEpay\Epay;

class EpayCreditCard extends Epay
{
	/**
	 * @var string cardholder
	 */
    public String $cardholder;
    /**
	 * @var string number
	 */
    public String $number;
    /**
	 * @var string expiration
	 */
    public String $expiration;
    /**
	 * @var string cvc
	 */
    public Int $cvc;
    /**
	 * @var string avs_street
	 */
    public String $avs_street;
    /**
	 * @var string avs_postalcode
	 */
    public String $avs_postalcode;
    
}
