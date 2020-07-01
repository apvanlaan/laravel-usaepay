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
		$epayb = new EpayBatch();
		$test = $epayb->new($arr);
		if(is_string($test)){
			throw new \Exception($test);
		}else{
			$this->batch = $epayb->new($arr);	
		}
		
	}
	public function list(){
		$res = $this->batch->listBatches();
		return $res;
	}
	public function retrieve(Request $request){
		try{
		$res = $this->batch->retrieveBatch();
			return response($res,200);
		}catch(\Exception $e){
			return response($e->getMessage(),$e->getCode());
		}
	}
	public function current(){
		$res = $this->batch->currentBatch();
		return $res;
	}
	public function currentTransactions(){
		$res = $this->batch->getCurrentBatchTransactions();
		return $res;
	}
	public function transactionsByBatch(Request $request){
		$res = $this->batch->getTransactionsByBatch();
		return $res;
	}
	public function close(Request $request){
		$res = $this->batch->closeBatch();
		return json_encode($res);
	}
}