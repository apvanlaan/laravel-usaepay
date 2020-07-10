# USAePay Rest API Package for Laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]

Project was created by, and is maintained by [Aaron VanLaan][link-author].

## Usage

## Table Of Content

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [EpayCustomer Class](#epaycustomer-class)
    * [Parameters](#epaycustomer-class-parameters)  
    * [Methods](#epaycustomer-class-example)
4. [EpayTransaction Class](#epaytransaction-class)
    * [Parameters](#epaytransaction-class-parameters)
    * [Methods](#epaytransaction-class-example)
    * [EpayTransaction Child Classes](#epaytransaction-class-children)
    	* [EpayAmountDetail Class](#epayamountdetail-class)
    	* [EpayCreditCard Class](#epaycreditcard-class)
    	* [EpayCustomerAddress Class](#epaycustomeraddress-class)
    	* [EpayCustomField Class (COMING SOON)](#epaycustomfield-class)
    	* [EpayLineItem Class](#epaylineitem-class)
    	* [EpayTrait Class](#epaytrait-class)
5. [EpayBatch Class](#epaybatch-class)
    * [Parameters](#epaybatch-class-parameters)
    * [Methods](#epaybatch-class-example)
6. [EpayProduct Class](#epayproduct-class)
    * [Parameters](#epayproduct-class-parameters)
    * [Methods](#epayproduct-class-example)
7. [EpayCategory Class](#epaycategory-class)
    * [Parameters](#epaycategory-class-parameters)
    * [Methods](#epaycategory-class-example)
8. [EpayInventory Class (COMING SOON)](#epayinventory-class)
    * [Parameters](#epayinventory-class-parameters)
    * [Methods](#epayinventory-class-example)

<a name="requirements"></a>
## Requirements

This library uses PHP 7.4+ and Laravel 6+

You can find the USAePay Rest API docs here : https://help.usaepay.info/api/rest/
<a name="installation"></a>
## Installation

Require via Composer

``` bash
$ composer require apvanlaan/usaepay
```

Publish Assets
``` bash
$ php artisan vendor:publish --provider="Apvanlaan\UsaEpay\UsaEpayServiceProvider"
```

Add required ENV variables to .env
```
EPAYAPI=
#EPAYPIN= (optional, only include if pin is utilized)
EPAYPUBLIC=
EPAY_SUB=sandbox (change to secure for production)
#EPAY_ENDPOINT= (optional, use if using a custom endpoint, otherwise defaults to v2)
```

Note: In the following sections, the included routes relate to the controllers I have included in the package.  If you end up rolling your own then obviously you can ignore those.  The required fields, however, are required via the USAePay API, so those must remain. 

<a name="epaycustomer-class"></a>
## EpayCustomer Class

The EpayCustomer Class handles the creation of the Customer object and the associated api calls.

<a name="epaycustomer-class-parameters"></a>
### Parameters

EpayCustomer parameters are:
(note: all listed required are the minimum required by the USAePay API)

* `company` String
* `first_name` String
* `last_name` String
* `customerid` String
* `street` String
* `street2`
* `city` String
* `state` String
* `postalcode` String
* `country` String
* `phone` String
* `fax` String
* `email` String
* `url` String
* `notes` String
* `description` String
* `custkey` String
 
<a name="epaycustomer-class-example"></a>

### EpayCustomer Methods w/ default required params and Examples
#### (note: there are two ways to instantiate the epay classes, you can pass an array/object with the paramters or you can instantiate an empty class and manually set the parameters as needed.)

#### 	getCustomer()
* Route : ` GET epay/customer/get/{custkey}`
* Required : `custkey`

```php
$customer = new EpayCustomer();
$customer->custkey = $custkey;

return $customer->getCustomer();
```

#### 	listCustomers()
* Route : `GET epay/customer/list`
* Required : `none`

```php
$customer = new EpayCustomer();

return $customer->listCustomers();
```

#### 	addCustomer()
* Route : `POST epay/customer/create`
* Required : `company (if no first_name && last_name), first_name (if no company), last_name (if no company)`

```php
$customer = new EpayCustomer();
$params = ['first_name' =>"John",'last_name' =>"Doe",'street' =>"123 House Rd",'city' =>"Beverly Hills",'state' =>"CA",'postalcode' =>"90210",'country' =>"USA",'phone' =>"5558675309",'email' =>"john.doe@email.com",'description' =>"Fake customer information for testing."];
return $customer->addCustomer($params);
```

#### 	updateCustomer()
* Route : `POST epay/customer/update`
* Required : `custkey`

```php
$customerUpdate = new \StdClass();
$customerUpdate->custkey = "asdf";
$customerUpdate->description = 'Still a fake customer used for testing';

$customer = new EpayCustomer($params);

return $customer->updateCustomer();
```

#### 	deleteCustomer()
* Route : `POST epay/customer/delete`
* Required : `custkey`

```php
$params = ['custkey'=>$request->custkey];
$customer = new EpayCustomer($params);

return $customer->deleteCustomer();
```

<a name="epaytransaction-class"></a>
## EpayTransaction Class

The EpayTransaction Class handles the creation of the Transaction object and the associated api calls.


<a name="epaytransaction-class-parameters"></a>
### Parameters

EpayTransaction parameters are:

* `trankey` String
* `refnum` String
* `invoice` String
* `ponum` String
* `orderid` String
* `description` String 
* `comments` String
* `email` String
* `merchemailaddr` String
* `amount` Float
* `amount_detail` Transactions\EpayAmountDetail
* `creditcard` Transactions\EpayCreditCard
* `save_card` Bool
* `traits` Transactions\EpayTrait
* `custkey` String 
* `save_customer` Bool
* `save_customer_paymethod` Bool
* `billing_address` Transactions\EpayCustomerAddress
* `shipping_address` Transactions\EpayCustomerAddress
* `lineitmes` Transactions\EpayLineItem
* `custom_fields` Transactions\EpayCustomField
* `currency` String 
* `terminal` String 
* `clerk` String 
* `clientip` String 
* `software` String 

<a name="epaytransaction-class-example"></a>
### EpayTransaction Methods w/ default required params

#### 	listAuthorized()
* Route : `GET epay/transaction/list`
* Required : `none`

#### 	listAuthorized()
* Route : `GET epay/transaction/list`
* Required : `trankey`

#### 	createSale()
* Route : `POST epay/transaction/sale`
* Required : `amount, payment_key (if no creditcard), creditcard (if no payment_key)`

#### 	createRefund()
* Required : `amount, creditcard`

#### 	createVoid()
* Route : `POST epay/transaction/void`
* Required : `trankey (if no refnum), refnum (if no trankey)`

#### 	authorizeTransaction()
* Route : `POST epay/transaction/auth`
* Required : `amount, payment_key (if no creditcard), creditcard (if no payment_key)`

#### 	captureTransaction()
* Route : `POST epay/transaction/capture`
* Required : `trankey (if no refnum), refnum (if no trankey)`

<a name="epaytransaction-class-children"></a>
### EpayTransaction Child Classes

<a name="epayamountdetail-class"></a>
### EpayAmountDetail Class & Parameters
* `subtotal` Double
* `tax` Double
* `nontaxable` Bool
* `tip` Double
* `discount` Double
* `shipping` Double
* `duty` Double
* `enable_partialauth` Bool

<a name="epaycreditcard-class"></a>
### EpayCreditCard Class & Parameters
* `cardholder` String
* `number` String
* `expiration` String
* `cvc` Int
* `avs_street` String
* `avs_postalcode` String

<a name="epaycustomeraddress-class"></a>
### EpayCustomerAddress Class & Parameters
* `company` String
* `firstname` String
* `lastname` String
* `street` String
* `street2` String
* `city` String
* `state` String
* `postalcode` String
* `country` String
* `phone` String
* `fax; ` String


<a name="epaylineitem-class"></a>
### EpayLineItem Class & Parameters
* `product_key` String
* `name` String
* `cost` Double
* `qty` Int
* `description` String
* `sku` String
* `taxable` Bool
* `tax_amount` Double
* `tax_rate` String
* `discount_rate` String
* `discount_amount` Double
* `location_key` String
* `commodity_code` String

<a name="epaytrait-class"></a>
### EpayTrait Class & Parameters
* `is_debt` Bool
* `is_bill_pay` Bool
* `is_recurring` Bool
* `is_healthcare` Bool
* `is_cash_advance` Bool
* `secure_collection` Int
<a name="epaybatch-class"></a>
## EpayBatch Class

The EpayBatch Class handles the creation of the Batch object and the associated api calls.

<a name="epaybatch-class-parameters"></a>
### Parameters

EpayBatch parameters are:

* `limit` Int 
* `offset` Int 
* `openedlt` String 
* `openedgt` String 
* `closedlt` String 
* `closedgt` String 
* `openedle` String 
* `openedge` String 
* `closedle` String 
* `closedge` String 
* `batch_key` String 

<a name="epaybatch-class-example"></a>
### EpayBatch Methods w/ default required params

#### 	listBatches()
* Route : `GET epay/batch/list`
* Required : `none`

#### 	currentBatch()
* Route : `GET epay/batch/current`
* Required : `none`

#### 	retrieveBatch()
* Route : `POST epay/batch/retrieve`
* Required : `batch_key`

#### 	getCurrentBatchTransactions()
* Route : `GET epay/batch/currentTransactions`
* Required : `none`

#### 	getTransactionsByBatch()
* Route : `GET epay/batch/transactionsByBatch`
* Required : `trankey (if no refnum), refnum (if no trankey)`

#### 	closeBatch()
* Route : `POST epay/batch/close`
* Required : `batch_key`


<a name="epayproduct-class"></a>
## EpayProduct Class

The EpayProduct Class handles the creation of the Product object and the associated api calls.

<a name="epayproduct-class-parameters"></a>
### Parameters

* `name` String
* `price` Float
* `enabled` Bool
* `taxable` Bool
* `available_all` Bool
* `available_all_date` String
* `categoryid` Int
* `commodity_code` String
* `date_available` String
* `description` String
* `list_price` Float
* `wholesale_price` Float
* `manufacturer` String
* `merch_productid` String
* `min_quantity` Int
* `model` String
* `physicalgood` Bool
* `weight` Int
* `ship_weight` Int
* `sku` String
* `taxclass` String
* `um` String
* `upc` String
* `url` String
* `allow_override` Bool
* `product_key` String
* `limit` Int
* `offset` Int
* `inventory` Array
* `modifiers` Array

<a name="epayproduct-class-example"></a>
### EpayProduct Methods w/ default required params

#### 	listProducts()
* Route : `GET epay/product/list`
* Required : `none`

#### 	createProduct()
* Route : `POST epay/product/create`
* Required : `name`

#### 	getProduct()
* Route : `GET epay/product/get`
* Required : `product_key`

#### 	updateProduct()
* Route : `POST epay/product/update`
* Required : `product_key`

#### 	deleteProduct()
* Route : `POST epay/product/delete`
* Required : `product_key`


<a name="epaycategory-class"></a>
## EpayCategory Class

The EpayCategory Class handles the creation of the Category object and the associated api calls.

<a name="epaycategory-class-parameters"></a>
### Parameters

* `name` String
* `categorykey` String
* `limit` Int
* `offset` Int
* `modifiers` Array

<a name="epaycategory-class-example"></a>
### EpayCategory Methods w/ default required params

#### 	listCategories()
* Route : `GET epay/category/list`
* Required : `none`

#### 	createCategory()
* Route : `POST epay/category/create`
* Required : `name`

#### 	getCategory()
* Route : `GET epay/category/get`
* Required : `category_key`

#### 	updateCategory()
* Route : `POST epay/category/update`
* Required : `category_key`

#### 	deleteCategory()
* Route : `POST epay/category/delete`
* Required : `category_key`

<a name="epayinventory-class"></a>
## EpayInventory Class

(COMING SOON)


<a name="epayinventory-class-parameters"></a>
### Parameters (COMING SOON)

<a name="epayinventory-class-example"></a>
## EpayInventory Methods w/ default required params (COMING SOON)

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Credits

- [Aaron VanLaan][link-author]

## License

The USAePay REST API Package for Laravel is open-sourced software licensed under the [MIT license](LICENSE.md).

[ico-version]: https://img.shields.io/packagist/v/apvanlaan/usaepay.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/apvanlaan/usaepay.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/apvanlaan/usaepay/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/apvanlaan/usaepay
[link-downloads]: https://packagist.org/packages/apvanlaan/usaepay
[link-travis]: https://travis-ci.org/apvanlaan/usaepay
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/apvanlaan