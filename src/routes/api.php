<?php

use Illuminate\Support\Facades\Route;
use Apvanlaan\UsaEpay\Http\Controllers\CustomerController;
use Apvanlaan\UsaEpay\Http\Controllers\TransactionController;
use Apvanlaan\UsaEpay\Http\Controllers\BatchController;
use Apvanlaan\UsaEpay\Http\Controllers\ProductController;
use Apvanlaan\UsaEpay\Http\Controllers\CategoryController;

Route::group(['prefix' => 'api', 'middleware' => 'api'], function() {

	// Customers
	Route::post('/epay/customer/create',[CustomerController::class,'createCustomer'])->name('customer.create');
	Route::get('/epay/customer/get/{custkey}',[CustomerController::class,'getCustomer'])->name('customer.get');
	Route::get('/epay/customer/list',[CustomerController::class,'listCustomers'])->name('customer.list');
	Route::post('/epay/customer/update',[CustomerController::class,'updateCustomer'])->name('customer.update');
	Route::post('/epay/customer/delete',[CustomerController::class,'deleteCustomer'])->name('customer.delete');

	// Transactions
	Route::get('/epay/transaction/get/{trankey}',[TransactionController::class,'get'])->name('transaction.get');
	Route::get('/epay/transaction/list',[TransactionController::class,'listAuths'])->name('transaction.listAuths');
	Route::post('/epay/transaction/capture',[TransactionController::class,'capture'])->name('transaction.capture');
	Route::post('/epay/transaction/auth',[TransactionController::class,'auth'])->name('transaction.auth');
	Route::post('/epay/transaction/void',[TransactionController::class,'void'])->name('transaction.void');
	Route::post('/epay/transaction/sale',[TransactionController::class,'sale'])->name('transaction.sale');

	// Batches
	Route::get('/epay/batch/list',[BatchController::class,'list'])->name('batch.list');
	Route::get('/epay/batch/current',[BatchController::class,'current'])->name('batch.current');
	Route::get('/epay/batch/currentTransactions',[BatchController::class,'currentTransactions'])->name('batch.currentTransactions');
	Route::post('/epay/batch/retrieve',[BatchController::class,'retrieve'])->name('batch.retrieve');
	Route::get('/epay/batch/transactionsByBatch/{batchkey}',[BatchController::class,'transactionsByBatch'])->name('batch.transactionsByBatch');
	Route::post('/epay/batch/close',[BatchController::class,'close'])->name('batch.close');

	// Products
	Route::post('/epay/product/create',[ProductController::class,'create'])->name('product.create');
	Route::get('/epay/product/get/{productkey}',[ProductController::class,'get'])->name('product.get');
	Route::get('/epay/product/list',[ProductController::class,'list'])->name('product.list');
	Route::post('/epay/product/update',[ProductController::class,'update'])->name('product.update');
	Route::post('/epay/product/delete',[ProductController::class,'delete'])->name('product.delete');

	// Categories
	Route::post('/epay/category/create',[CategoryController::class,'create'])->name('category.create');
	Route::get('/epay/category/get/{categorykey}',[CategoryController::class,'get'])->name('category.get');
	Route::get('/epay/category/list',[CategoryController::class,'list'])->name('category.list');
	Route::post('/epay/category/update',[CategoryController::class,'update'])->name('category.update');
	Route::post('/epay/category/delete',[CategoryController::class,'delete'])->name('category.delete');

});