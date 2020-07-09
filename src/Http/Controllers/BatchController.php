<?php

namespace Apvanlaan\UsaEpay\Http\Controllers;

use Apvanlaan\UsaEpay\UsaEpay;
use Apvanlaan\UsaEpay\EpayBatch;
use Response;
use Illuminate\Http\Request;

class BatchController extends Controller
{

	public EpayBatch $batch;

	public function __construct(Request $request){
		$arr = $request->all();
		if($request->limit){
			$arr['limit'] = $arr['limit'] *1;
		}
		if($request->offset){
			$arr['offset'] = $arr['offset'] *1;
		}
		$this->batch = new EpayBatch($arr);
		
		if(is_string($this->batch)){
			throw new \Exception($test);
		}
		
	}
	public function list(){
	
			$res = $this->batch->listBatches();
			return $res;
		
	}
	public function retrieve(Request $request){
		
		$res = $this->batch->retrieveBatch();
			return response($res,200);
		
	}
	public function current(){
		
			$res = $this->batch->currentBatch();
			return $res;
		
	}
	public function currentTransactions(){
		
			$res = $this->batch->getCurrentBatchTransactions();
			return $res;
		
	}
	public function transactionsByBatch($batchkey){
			$this->batch_key = $batchkey;
			$res = $this->batch->getTransactionsByBatch();
			return $res;
		
	}
	public function close(Request $request){
		
			$res = $this->batch->closeBatch();
			return json_encode($res);
		
	}
}