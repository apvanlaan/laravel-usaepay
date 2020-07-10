<?php

namespace Apvanlaan\UsaEpay;

class UsaEpay
{
    private $password;
    public $base_url = '';
    public $timeout = '45';
    public $subdomain = '';
    public $endpoint = 'v2';
    public $available_subdomains;
    public $curl;

    public function __construct($api_key = '', $api_pin = '', $sub = '', $end = '')
    {
        if ($api_key == '') {
            $api_key = config('usaepay.apikey');
        }

        if ($api_pin == '') {
            $api_pin = config('usaepay.pin');
        }

        if ($sub == '') {
            $sub = config('usaepay.epaysub');
        }

        if ($end == '') {
            $end = config('usaepay.endpoint');
        }

        $seed = substr(hash('sha256', rand()), 10, 25);
        $prehash = $api_key.$seed.$api_pin;

        $hash = 's2/'.$seed.'/'.hash('sha256', $prehash);

        $un = $api_key.':'.$hash;
        $this->password = $un;

        if ($sub != '') {
            $this->subdomain = $sub.'.';
        }
        if ($end != '') {
            $this->endpoint = $end;
        }
        $this->base_url = 'https://'.$this->subdomain.'usaeapy.com/api/'.$this->endpoint;
    }

    private function setTimeOut($timeout_value)
    {
        if ($timeout_value > 60 || $timeout_value < 1) {
            throw new Exception\SDKException('Invalid timeout value, please pick a value between 0-60.');
        }
        $this->timeout = $timeout_value;
    }

    public function curlStart($serv)
    {
        $headers = ['Content-type: application/json'];

        curl_setopt($this->curl, CURLOPT_URL, $serv);
        curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($this->curl, CURLOPT_USERPWD, $this->password);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeout);
    }

    public function get($path, $data)
    {
        $service_url = 'https://'.$this->subdomain.'usaepay.com/api/'.$this->endpoint.$path;
        $this->curl = curl_init($service_url);
        $this->curlStart($service_url);
        curl_setopt($this->curl, CURLOPT_POST, false);
        $curl_response = curl_exec($this->curl);

        return $curl_response;
        $res = $this->doCurl();

        return $res;
    }

    public function list($path)
    {
        $service_url = 'https://'.$this->subdomain.'usaepay.com/api/'.$this->endpoint.$path;
        $this->curl = curl_init($service_url);
        $this->curlStart($service_url);
        curl_setopt($this->curl, CURLOPT_POST, false);
        $res = $this->doCurl();

        return $res;
    }

    public function post($path, $data)
    {
        $json = json_encode($data);
        $service_url = 'https://'.$this->subdomain.'usaepay.com/api/'.$this->endpoint.$path;
        $this->curl = curl_init($service_url);
        $this->curlStart($service_url);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $json);
        $res = $this->doCurl();

        return $res;
    }

    public function put($path, $data)
    {
        $json = json_encode($data);
        $service_url = 'https://'.$this->subdomain.'usaepay.com/api/'.$this->endpoint.$path;
        $this->curl = curl_init($service_url);
        $this->curlStart($service_url);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $json);
        $res = $this->doCurl();

        return $res;
    }

    public function delete($path, $data)
    {
        $json = json_encode($data);
        $service_url = 'https://'.$this->subdomain.'usaepay.com/api/'.$this->endpoint.$path;
        $this->curl = curl_init($service_url);
        $this->curlStart($service_url);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $json);
        $res = $this->doCurl();

        return $res;
    }

    public function doCurl()
    {
        try {
            $curl_response = curl_exec($this->curl);

            if (! $curl_response) {
                return curl_error($this->curl);
            }

            $response = json_decode($curl_response);

            if (is_object($response)) {
                if (property_exists($response, 'error') && (! property_exists($response, 'result') || $response->result == 'error')) {
                    return ['result'=>'failure', 'response'=>$response->error, 'code'=>$response->errorcode];
                }
            }

            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
