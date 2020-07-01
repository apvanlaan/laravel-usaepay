<?php

namespace Apvanlaan\UsaEpay;
use Apvanlaan\UsaEpay\Epay;

class EpayTransaction extends Epay
{
    /**
     * @var $command String
     */
    public String $command;
    public String $trankey;
    public String $refnum;
    public String $invoice;
    public String $ponum;
    public String $orderid;
    public String $description;
    public String $comments;
    public String $email;
    public Boolean $send_receipt;
    public String $merchemailaddr;
    public Float $amount;

    public Transactions\EpayAmountDetail $amount_detail;

    public Transactions\EpayCreditCard $creditcard;

    public Boolean $save_card;

    public Transactions\EpayTrait $traits;

    public String $custkey;

    public Boolean $save_customer;

    public Boolean $save_customer_paymethod;

    public Transactions\EpayCustomerAddress $billing_address;
    public Transactions\EpayCustomerAddress $shipping_address;

    public Transactions\EpayLineItem $lineitmes;

    public Transactions\EpayCustomField $custom_fields;

    public String $currency;
    public String $terminal;
    public String $clerk;
    public String $clientip;

    public String $software;
    
    public function getTransaction(){
        $required = ['transaction_key'];

        $validated = $this->validate($required);
        
        if($validated){
            $key = $this->transaction_key;
            $transaction = $this;
            
            $res = $this->epay->get("/transactions/$key",$transaction);
            return $res;
        }else{
            return "validation error";
        }
        

    }

    public function createSale(){
        
        $this->command = 'sale';

        $required = $this->setRequired(['amount'],['payment_key'=>'creditcard']);
        $validated = $this->validate($required);

        if($validated){
            $transaction = $this;
            $res = $this->epay->post("/transactions",$transaction);
            return $res;
        }else{
            return "validation error";
        }
    }

    public function createRefund(){
        $required = [];
        $this->command = 'refund';
        if(!isset($this->refnum) && !isset($this->trankey)){
            array_push($required,'amount');
            array_push($required,'creditcard');
        }
        $validated = $this->validate($required);
        if($validated){
            $transaction = $this;
            $res = $this->epay->post("/transactions",$transaction);
            return $res;
        }else{
            return "validation error";
        }
    }


    public function createVoid(){
        $required = $this->setRequire([],['trankey'=>'refnum','refnum'=>'trankey']);
        $this->command = 'void';
        
        $validated = $this->validate($required);
        if($validated){
            $transaction = $this;
            $res = $this->epay->post("/transactions",$transaction);
            return $res;
        }else{
            return "validation error";
        }
    }

    public function authorizeTransaction(){
        $this->command = 'authonly';
        $required = $this->setRequired(['amount'],['payment_key'=>'creditcard']);
        
        $validated = $this->validate($required);
        
        if($validated){
            $transaction = $this;
            $res = $this->epay->post("/transactions",$transaction);
            return $res;
        }else{
            return "validation error";
        }
    }

    public function captureTransaction(){
        $this->command = "cc:capture:" . config('usaepay.capture_type');
        $required = $this->setRequire([],['trankey'=>'refnum','refnum'=>'trankey']);
        $validated = $this->validate($required);
        
        if($validated){
            $transaction = $this;
            $res = $this->epay->post("/transactions",$transaction);
            return $res;
        }else{
            return "validation error";
        }
    }

}