<?php

namespace Apvanlaan\UsaEpay;

class EpayBatch extends Epay
{
    public Int $limit;
    public Int $offset;
    public String $openedlt;
    public String $openedgt;
    public String $closedlt;
    public String $closedgt;
    public String $openedle;
    public String $openedge;
    public String $closedle;
    public String $closedge;
    public String $batch_key;

    public function listBatches()
    {
        $batch = $this;
        $params = $this->createParams();

        $res = $this->epay->get('/batches'.$params, $batch);

        return $res;
    }

    public function currentBatch()
    {
        $batch = $this;

        $res = $this->epay->get('/batches/current', $batch);

        return $res;
    }

    public function retrieveBatch()
    {
        $required = $this->setRequired(['batch_key'], []);
        $validated = $this->validate($required);

        if ($validated === true) {
            $batch = $this;
            $res = $this->epay->get('/batches/'.$this->batch_key, $batch);

            return $res;
        } else {
            throw new \Exception($validated, 444);
        }
    }

    public function getCurrentBatchTransactions()
    {
        $batch = $this;
        $params = $this->createParams();
        $res = $this->epay->get('/batches/current/transactions'.$params, $batch);

        return $res;
    }

    public function getTransactionsByBatch()
    {
        $required = $this->setRequired(['batch_key'], []);
        $validated = $this->validate($required);
        $params = $this->createParams();
        if ($validated === true) {
            $batch = $this;
            $res = $this->epay->get('/batches/'.$this->batch_key.'/transactions'.$params, $batch);

            return $res;
        } else {
            //return ['error'=>$validated];
            throw new \Exception($validated);
        }
    }

    public function closeBatch()
    {
        $required = $this->setRequired(['batch_key'], []);
        $validated = $this->validate($required);

        if ($validated === true) {
            $batch = $this;
            $res = $this->epay->post('/batches/current/close', $batch);

            return $res;
        } else {
            return ['error'=>$validated];
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
                case 'openedlt':
                case 'openedgt':
                case 'closedlt':
                case 'closedgt':
                case 'openedle':
                case 'openedge':
                case 'closedle':
                case 'closedge':
                    $params .= "?$key=$value";
                break;
            }
        }

        return $params;
    }
}
