<?php

namespace Apvanlaan\UsaEpay\Http\Controllers;

use Apvanlaan\UsaEpay\EpayTransaction;
use Apvanlaan\UsaEpay\Transactions\EpayAmountDetail;
use Apvanlaan\UsaEpay\Transactions\EpayCreditCard;
use Apvanlaan\UsaEpay\Transactions\EpayCustomerAddress;
use Apvanlaan\UsaEpay\Transactions\EpayLineItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public EpayTransaction $transaction;

    public function __construct(Request $request = null)
    {
        if ($request !== null) {
            $arr = $request->all();
            if ($request->creditcard) {
                $res = $this->setElement($request->creditcard, 'cc');
                $arr['creditcard'] = $res;
            }
            if ($request->billing_address) {
                $res = $this->setElement($request->billing_address, 'billing');
                $arr['billing_address'] = $res;
            }
            if ($request->shipping_address) {
                $res = $this->setElement($request->billing_address, 'shipping');
                $arr['shipping_address'] = $res;
            }
            if ($request->amountdetail) {
                $res = $this->setElement($request->amountdetail, 'amountdetail');
                $arr['amount_detail'] = $res;
            }
            if ($request->lineitems) {
                $lis = [];
                foreach ($request->lineitems as $lineitem) {
                    $res = $this->setElement($lineitem, 'lineitem');
                    array_push($lis, $res);
                }
                $arr['lineitems'] = $lis;
            }
            if ($request->keyset) {
                unset($arr['keyset']);

                $this->transaction = new EpayTransaction($arr, $request->keyset);
            } else {
                $this->transaction = new EpayTransaction($arr);
            }
            $this->transaction->{'receipt-custemail'} = 'none';
            if ($this->transaction instanceof EpayTransaction) {
            } else {
                throw new \Exception($test->getMessage(), 444);
            }
        } else {
            $this->transaction = new EpayTransaction();
        }
    }

    public function listAuths()
    {
        $res = $this->transaction->listAuthorized();

        return $res;
    }

    public function get($trankey)
    {
        $this->transaction->trankey = $trankey;
        $res = $this->transaction->getTransaction();

        return $res;
    }

    public function sale(Request $request)
    {
        $res = $this->transaction->createSale();

        return json_encode($res);
    }

    public function auth(Request $request)
    {
        $res = $this->transaction->authorizeTransaction();

        return json_encode($res);
    }

    public function capture(Request $request)
    {
        $res = $this->transaction->captureTransaction();

        return json_encode($res);
    }

    public function refund(Request $request)
    {
        $res = $this->transaction->createRefund();

        return json_encode($res);
    }

    public function void(Request $request)
    {
        $res = $this->transaction->createVoid();

        return json_encode($res);
    }

    public function setElement($data, $type)
    {
        $params = [];
        $element;
        foreach ($data as $k=>$v) {
            if (! empty($v)) {
                $params[$k] = $v;
            }
        }
        switch ($type) {
            case 'cc':
                $element = new EpayCreditCard($params);
            break;
            case 'billing':
            case 'shipping':
                $element = new EpayCustomerAddress($params);
            break;
            case 'lineitem':
                $element = new EpayLineItem($params);
            break;
            case 'amountdetail':
                $element = new EpayAmountDetail($params);
            break;
        }

        return $element;
    }
}
