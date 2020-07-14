<?php

namespace Apvanlaan\UsaEpay;

class EpayTransaction extends Epay
{
    public String $command;
    public String $trankey;
    public String $refnum;
    public String $invoice;
    public String $ponum;
    public String $orderid;
    public String $description;
    public String $comments;
    public String $email;
    public String $merchemailaddr;
    public Float $amount;

    public Transactions\EpayAmountDetail $amount_detail;

    public Transactions\EpayCreditCard $creditcard;

    public Bool $save_card;

    public Transactions\EpayTrait $traits;

    public String $custkey;

    public Bool $save_customer;

    public Bool $save_customer_paymethod;

    public Transactions\EpayCustomerAddress $billing_address;
    public Transactions\EpayCustomerAddress $shipping_address;

    public array $lineitems;

    public Transactions\EpayLineItem $lineitem;

    public Transactions\EpayCustomField $custom_fields;

    public String $currency;
    public String $terminal;
    public String $clerk;
    public String $clientip;
    public String $software;

    public function listAuthorized()
    {
        $transaction = $this;
        $res = $this->epay->get('/transactions', $transaction);

        return $res;
        // https://secure.usaepay.com/api/v2/transactions?filters=@trantype_code
    }

    public function getTransaction()
    {
        $required = ['trankey'];

        $validated = $this->validate($required);

        if ($validated === true) {
            $key = $this->trankey;
            $transaction = $this;

            $res = $this->epay->get("/transactions/$key", $transaction);

            return $res;
        } else {
            throw new \Exception($validated, 444);
        }
    }

    public function createSale()
    {
        $this->command = 'sale';

        $required = $this->setRequired(['amount'], ['payment_key'=>'creditcard']);
        $validated = $this->validate($required);

        if ($validated === true) {
            $transaction = $this;
            $res = $this->epay->post('/transactions', $transaction);

            return $res;
        } else {
            throw new \Exception($validated, 444);
        }
    }

    public function createRefund()
    {
        $required = [];
        $this->command = 'refund';
        if (! isset($this->refnum) && ! isset($this->trankey)) {
            array_push($required, 'amount');
            array_push($required, 'creditcard');
        }
        $validated = $this->validate($required);
        if ($validated === true) {
            $transaction = $this;
            $res = $this->epay->post('/transactions', $transaction);

            return $res;
        } else {
            throw new \Exception($validated, 444);
        }
    }

    public function createVoid()
    {
        $required = $this->setRequired([], ['trankey'=>'refnum', 'refnum'=>'trankey']);
        $this->command = 'void';

        $validated = $this->validate($required);
        if ($validated === true) {
            $transaction = $this;
            $res = $this->epay->post('/transactions', $transaction);

            return $res;
        } else {
            throw new \Exception($validated, 444);
        }
    }

    public function authorizeTransaction()
    {
        $this->command = 'authonly';
        $required = $this->setRequired(['amount'], ['payment_key'=>'creditcard']);

        $validated = $this->validate($required);

        if ($validated === true) {
            $transaction = $this;

            $res = $this->epay->post('/transactions', $transaction);

            return $res;
        } else {
            throw new \Exception($validated, 444);
        }
    }

    public function captureTransaction()
    {
        $this->command = 'cc:capture:'.config('usaepay.capture_type');
        $required = $this->setRequired([], ['trankey'=>'refnum', 'refnum'=>'trankey']);
        $validated = $this->validate($required);

        if ($validated === true) {
            $transaction = $this;

            $res = $this->epay->post('/transactions', $transaction);

            return $res;
        } else {
            throw new \Exception($validated, 444);
        }
    }
}
