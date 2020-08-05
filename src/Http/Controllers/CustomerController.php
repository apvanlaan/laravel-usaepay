<?php

namespace Apvanlaan\UsaEpay\Http\Controllers;

use Apvanlaan\UsaEpay\EpayCustomer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public EpayCustomer $customer;

    public function __construct(Request $request)
    {
        $arr = $request->all();
        if($request->keyset){
                unset($arr['keyset']);

                $this->transaction = new EpayCustomer($arr,$request->keyset);
            }else{
                $this->transaction = new EpayCustomer($arr);    
            }
    }

    public function createCustomer(Request $request)
    {
        $res = $this->customer->addCustomer();

        return json_encode($res);
    }

    /**
     * [listCustomers description].
     * @return [type] [description]
     */
    public function listCustomers()
    {
        $res = $this->customer->listCustomers();

        return json_encode($res);
    }

    /**
     * [getCustomer description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getCustomer($custkey)
    {
        $this->customer->custkey = $custkey;
        $res = $this->customer->getCustomer();

        return $res;
    }

    /**
     * [updateCustomer description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateCustomer(Request $request)
    {
        $res = $this->customer->updateCustomer();

        return json_encode($res);
    }

    /**
     * [deleteCustomer description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteCustomer(Request $request)
    {
        $res = $this->customer->deleteCustomer();

        return json_encode($res);
    }
}
