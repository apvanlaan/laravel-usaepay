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
9. [Examples](#examples)
    * [Example View](#example-view)
    * [Example Vue Component](#example-vue)
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

<a name="examples"></a>
## Examples

The following is an example of creating a View in Laravel that utilizes a Vue Component 

<a name="example-view"></a>
### Example View

::: v-pre
`<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.usaepay.com/js/v1/pay.js"></script>
</head>
<body>
    <div id='app'>
        <div class='col'>
            <h2>Payment/Auth Form</h2>
            <paymentform publickey={{config('usaepay.publickey')}}></paymentform>
        </div>
        <div class='col'>
            <h2>Transaction List</h2>
            <transactionlist></transactionlist>
        </div>
    </div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
</html>`
:::

<a name="example-vue"></a>
### Example Vue Component

::: v-pre
`<template>
    <div>
        <form class='paymentForm' @submit.prevent='submitForm'>
                <div class='form-group'>
            <label for='saveCust'>Save Customer?</label>
            <input type='checkbox' name='saveCust' v-model='saveCust' />
            </div>
                <div class='form-group'>
            <label for='type'>Transaction Type</label>
                <div class='form-group'>
            <label>Authorization <input type='radio' value='auth' name='type' v-model='transaction.type' /></label>
            </div>
                <div class='form-group'>
            <label>Sale <input type='radio' value='sale' name='type' v-model='transaction.type' /></label>
            </div>
            </div>
                <div class='form-group'>
            <label for='amount'>Amount : ${{transaction.amount}}</label>
            </div>
                <div class='form-group'>
            <label for="email">Email</label>
            <input type="email" v-model="transaction.email" required/>
            </div>
            <div id='shipping_address'>
                <div class='form-group'>
                    <label class='label' for="company">Company</label>
                    <input type="text" name="company" v-model='transaction.shipping_address.company' />
                </div>
                <div class='form-group'>
                    <label class='label' for="firstname">First Name</label>
                    <input type="text" name="firstname" v-model='transaction.shipping_address.firstname' />
                </div>
                <div class='form-group'>
                    <label class='label' for="lastname">Last Name</label>
                    <input type="text" name="lastname" v-model='transaction.shipping_address.lastname' />
                </div>
                <div class='form-group'>
                    <label class='label' for="street">Address</label>
                    <input type="text" name="street" v-model='transaction.shipping_address.street' required/>
                </div>
                <div class='form-group'>
                    <label class='label' for="street2">Apt / Building</label>
                    <input type="text" name="street2" v-model='transaction.shipping_address.street2' />
                </div>
                <div class='form-group'>
                    <label class='label' for="city">City</label>
                    <input type='text' name='city' v-model='transaction.shipping_address.city' required/>
                </div>
                <div class='form-group'>
                    <label class='label' for="state">State</label>
                    <input type="text" name="state" v-model='transaction.shipping_address.state' required/>
                </div>
                <div class='form-group'>
                    <label class='label' for="postalcode">Zip</label>
                    <input type="text" name="postalcode" v-model='transaction.shipping_address.postalcode' required/>
                </div>
                <div class='form-group'>
                    <label class='label' for="country">Country</label>
                    <select name="country" v-model='transaction.shipping_address.country' required>
                        <option value="Select Country">Select Country</option>
                        <option value="US">US</option>
                        <option value="CA">Canada</option>
                    </select>
                </div>
                <div class='form-group'>
                    <label class='label' for="phone">Phone#</label>
                    <input type="text" name="phone" v-model='transaction.shipping_address.phone' />
                    </div>
            </div>
            <div class='form-group'>
            <label class='label' for='diffBilling'>Different Billing Address?</label>
            <input type='checkbox' name='diffBilling' v-model='diffBilling'/>
            </div>
            <div v-if="diffBilling == true" id='billing_address'>
                <div class='form-group'>
                <label class='label' for="company">Company</label>
                <input type="text" name="company" v-model='transaction.billing_address.company' /></div>
                <div class='form-group'>
                <label class='label' for="firstname">First Name</label>
                <input type="text" name="firstname" v-model='transaction.billing_address.firstname' /></div>
                <div class='form-group'>
                <label class='label' for="lastname">Last Name</label>
                <input type="text" name="lastname" v-model='transaction.billing_address.lastname' /></div>
                <div class='form-group'>
                <label class='label' for="street">Address</label>
                <input type="text" name="street" v-model='transaction.billing_address.street' required/></div>
                <div class='form-group'>
                <label class='label' for="street2">Apt / Building</label>
                <input type="text" name="street2" v-model='transaction.billing_address.street2' /></div>
                <div class='form-group'>
                <label class='label' for="city">City</label>
                <input type='text' name='city' v-model='transaction.billing_address.city' required/></div>
                <div class='form-group'>
                <label class='label' for="state">State</label>
                <input type="text" name="state" v-model='transaction.billing_address.state' required/></div>
                <div class='form-group'>
                <label class='label' for="postalcode">Zip</label>
                <input type="text" name="postalcode" v-model='transaction.billing_address.postalcode' required/></div>
                <div class='form-group'>
                <label class='label' for="country">Country</label>
                <select name="country" v-model='transaction.billing_address.country' required>
                    <option value="Select Country">Select Country</option>
                    <option value="US">US</option>
                    <option value="CA">Canada</option>
                </select>
                </div>
                <div class='form-group'>
                <label for="phone">Phone#</label>
                <input type="text" name="phone" v-model='transaction.billing_address.phone' /></div>              
            </div>
            <creditcard ref='cc' :publickey=publickey></creditcard>
            <button type='submit'>Submit</button>
        </form>
    <div>Results : <pre>{{results}}</pre></div>
    </div>
</template>
<script>
    export default {
        props: ['publickey'],
        data() {
            return {
                transaction:{
                    billing_address:{
                        company:'',
                        firstname:'',
                        lastname:'',
                        street:'',
                        street2:'',
                        city:'',
                        state:'',
                        postalcode:'',
                        country:'',
                        phone:'',
                    },
                    shipping_address:{
                        company:'',
                        firstname:'',
                        lastname:'',
                        street:'',
                        street2:'',
                        city:'',
                        state:'',
                        postalcode:'',
                        country:'',
                        phone:'',
                    },
                    lineitems:[
                        {
                            name: "Test1",
                            cost: 3.50,
                            qty: 2,
                            description: "This is the first test item."
                        },
                        {
                            name: "Test2",
                            cost: 3.75,
                            qty: 1,
                            description: "This is the second test item."
                        }
                    ],
                    email:'',
                    type:'auth',
                    amount:3.5,                                
                },
                diffBilling:false,
                results:'',
                results_output:'',
                payment_key:'',
                saveCust:false,
            }
        },
        methods: {
            submitForm(){
                var self = this;
                self.$refs.cc.errormsg = '';
                var client = this.$refs.cc.client;
                var paymentCard = this.$refs.cc.paymentCard;
                if(!self.diffBilling){
                    self.transaction.billing_address = self.transaction.shipping_address;
                }
                client.getPaymentKey(paymentCard).then(result => {
                    if (result.error) {                       
                        self.$refs.cc.errormsg = result.error.message;
                    } else {
                        // do something with your payment key
                        self.payment_key = result;
                    }
                    self.transaction.payment_key = self.payment_key;
                    if(self.saveCust == true){
                        self.transaction.save_customer = 1;
                    }
                    axios.post('api/epay/transaction/' + self.transaction.type,self.transaction).then(function(response){
                        self.results = response.data;
                        if(self.saveCust == true){
                            axios.get('api/epay/customer/get/' + response.data.customer.custkey).then(function(customer){
                                self.results.customer = customer.data;                     
                            })
                        }
                         self.results_output = JSON.stringify(response.data,null,2); 
                    })
                    .catch(function(error){
                        console.log(error.response.data.message);
                        self.$refs.cc.errormsg = "An error has occurred.  Please check the form and try again.\r\n Error Message: " + error.response.data.message;
                    });
                });                
            },
        },
        watch:{   
        },
        computed: {  
        },
        mounted: function(){
        }
    }
</script>
<style>
.paymentForm{width:300px;}
</style>`
:::
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
[link-travis]: https://travis-ci.org/github/apvanlaan/laravel-usaepay
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/apvanlaan