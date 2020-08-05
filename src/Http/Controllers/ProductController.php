<?php

namespace Apvanlaan\UsaEpay\Http\Controllers;

use Apvanlaan\UsaEpay\EpayProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public EpayProduct $product;

    public function __construct(Request $request)
    {
        $arr = $request->all();
        if ($request->keyset) {
            unset($arr['keyset']);

            $this->transaction = new EpayProduct($arr, $request->keyset);
        } else {
            $this->transaction = new EpayProduct($arr);
        }
    }

    public function create(Request $request)
    {
        $res = $this->product->createProduct();

        return $res;
    }

    /**
     * [listProducts description].
     * @return [type] [description]
     */
    public function list()
    {
        $res = $this->product->listProducts();

        return $res;
    }

    /**
     * [get description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function get($productkey)
    {
        $this->product_key = $productkey;
        $res = $this->product->getProduct();

        return $res;
    }

    /**
     * [update description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        $res = $this->product->updateProduct();

        return json_encode($res);
    }

    /**
     * [delete description].
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function delete(Request $request)
    {
        $res = $this->product->deleteProduct();

        return json_encode($res);
    }
}
