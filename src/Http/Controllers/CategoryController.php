<?php

namespace Apvanlaan\UsaEpay\Http\Controllers;

use Apvanlaan\UsaEpay\UsaEpay;
use Apvanlaan\UsaEpay\EpayCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	public EpayCategory $category;

	public function __construct(Request $request){
		$arr = $request->all();
		$epayc = new EpayCategory();
		$this->category = $epayc->new($arr);
	}
	public function create(Request $request){
			
		$res = $this->category->createCategory();
		return json_encode($res);

	}
	/**
	 * [listCategorys description]
	 * @return [type] [description]
	 */
	public function list(){
		
		$res = $this->category->listCategorys();
		return json_encode($res);

	}
	/**
	 * [get description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function get(Request $request){
		
		$res = $this->category->getCategory();
		return json_encode($res);
	}
	/**
	 * [update description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function update(Request $request){
	

		$res = $this->category->updateCategory();
		return json_encode($res);

	}
	/**
	 * [delete description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function delete(Request $request){
		
		$res = $this->category->deleteCategory();
		return json_encode($res);
	}

}