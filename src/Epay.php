<?php

namespace Apvanlaan\UsaEpay;
use Apvanlaan\UsaEpay\UsaEpay;

class Epay
{
	public $epay;

	public function new($params = ''){
		try{
			if (is_array($params) || is_object($params)){
				foreach($params as $k=>$v){
					$this->$k = $v;
				}
			}else{
				return "Must use object or array to create new entity";
			}
			$this->epay = new UsaEpay();
			return $this;
		}catch(\Exception $e){
			return $e->getMessage();
		}catch(\TypeError $e){
			return $e->getMessage();
		}
	}
	public function validate($rules){

		$obj = $this;
		
		foreach($rules as $rule){

			if(!isset($obj->$rule)){
		
				return "$rule is required, please verify and try again.";
			}
		}
		return true;
	}

	public function setRequired($default,$params){
        $required = $default;

        foreach($params as $notset => $set){
            if(!isset($this->$notset)){
                array_push($required,$set);
            }
        }
        return $required;
    }
}