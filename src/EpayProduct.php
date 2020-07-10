<?php

namespace Apvanlaan\UsaEpay;

class EpayProduct extends Epay
{
    public String $name;
    public Float $price;
    public Bool $enabled;
    public Bool $taxable;
    public Bool $available_all;
    public String $available_all_date;
    public Int $categoryid;
    public String $commodity_code;
    public String $date_available;
    public String $description;
    public Float $list_price;
    public Float $wholesale_price;
    public String $manufacturer;
    public String $merch_productid;
    public Int $min_quantity;
    public String $model;
    public Bool $physicalgood;
    public Int $weight;
    public Int $ship_weight;
    public String $sku;
    public String $taxclass;
    public String $um;
    public String $upc;
    public String $url;
    public Bool $allow_override;
    public String $product_key;
    public Int $limit;
    public Int $offset;

    public array $inventory;
    public array $modifiers;

    public function listProducts()
    {
        $product = $this;
        $params = $this->createParams();
        $res = $this->epay->get('/products'.$params, $product);

        return $res;
    }

    public function createProduct()
    {
        $required = $this->setRequired(['name'], []);
        $validated = $this->validate($required);

        if ($validated) {
            $product = $this;
            $res = $this->epay->post('/products', $product);

            return $res;
        } else {
            return $validated;
        }
    }

    public function getProduct()
    {
        $required = $this->setRequired(['product_key'], []);
        $validated = $this->validate($required);

        if ($validated) {
            $product = $this;
            $res = $this->epay->get('/products/'.$this->product_key, $product);

            return $res;
        } else {
            return $validated;
        }
    }

    public function updateProduct()
    {
        $required = $this->setRequired(['product_key'], []);
        $validated = $this->validate($required);

        if ($validated) {
            $product = $this;
            $res = $this->epay->put('/products/'.$this->product_key, $product);

            return $res;
        } else {
            return $validated;
        }
    }

    public function deleteProduct()
    {
        $required = $this->setRequired(['product_key'], []);
        $validated = $this->validate($required);

        if ($validated) {
            $product = $this;
            $res = $this->epay->delete('/products/'.$this->product_key, $product);

            return $res;
        } else {
            return $validated;
        }
    }

    public function createParams()
    {
        $arr = (array) $this;
        $params = '';
        foreach ($arr as $key=>$value) {
            switch ($key) {
                case 'limit':
                case 'offset':
                    $params .= "?$key=$value";
                break;
            }
        }

        return $params;
    }
}
