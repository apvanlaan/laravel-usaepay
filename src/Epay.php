<?php

namespace Apvanlaan\UsaEpay;

class Epay
{
    public $epay;
    public $keyset;
    public function __construct($params = '',$keyset = '')
    {
        if ($params != '') {
            if (is_array($params) || is_object($params)) {
                foreach ($params as $k=>$v) {
                    $this->$k = $v;
                }
            } else {
                return 'Must use object or array to create new entity';
            }
        }
        $this->keyset = $keyset;
        $this->epay = new UsaEpay($keyset);
    }

    public function validate($rules)
    {
        $obj = $this;

        foreach ($rules as $rule) {
            if (! isset($obj->$rule)) {
                return "$rule is required, please verify and try again.";
            }
        }

        return true;
    }

    public function setRequired($default, $params)
    {
        $required = $default;

        foreach ($params as $notset => $set) {
            if (! isset($this->$notset)) {
                array_push($required, $set);
            }
        }

        return $required;
    }
}
