<?php

namespace Apvanlaan\UsaEpay;
use Apvanlaan\UsaEpay\Epay;

class EpayCategory extends Epay
{
    
    public String $name;
    public String $categorykey;
    public Int $limit;
    public Int $offset;

    public array $modifiers;

    public function listCategories(){
        
	    $category = $this;
        $params = $this->createParams();
	    $res = $this->epay->get("/products/categories" . $params,$category);
	    	return $res;
    }

    public function createCategory(){
		$required = $this->setRequired(['name'],[]);
        $validated = $this->validate($required);

        if($validated){
            $category = $this;
            $res = $this->epay->post("/products/categories",$category);
            return $res;
        }else{
            return $validated;
        }
    }

    public function getCategory(){
    	
    	$required = $this->setRequired(['category_key'],[]);
        $validated = $this->validate($required);

        if($validated){
            $category = $this;
            $res = $this->epay->get("/products/categories/" . $this->category_key,$category);
            return $res;
        }else{
            return $validated;
        }
    }

    public function updateCategory(){
    	$required = $this->setRequired(['category_key'],[]);
        $validated = $this->validate($required);

        if($validated){
            $category = $this;
            $res = $this->epay->put("/products/categories/" . $this->category_key,$category);
            return $res;
        }else{
            return $validated;
        }
    }

    public function deletecategory(){
    	$required = $this->setRequired(['category_key'],[]);
        $validated = $this->validate($required);

        if($validated){
            $category = $this;
            $res = $this->epay->delete("/products/categories/" . $this->category_key,$category);
            return $res;
        }else{
            return $validated;
        }
    }

    public function createParams(){
        $arr = (array)$this;
        $params = "";
        foreach($arr as $key=>$value){
            switch($key){
                case 'limit':
                case 'offset':
                    $params .= "?$key=$value";
                break;    
            }
            
        }
        return $params;
    }
}