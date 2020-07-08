# USAePay Rest API Package for Laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]

Project was created by, and is maintained by [Aaron VanLaan][link-author].

## Usage

## Table Of Content

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [EpayCustomer Class](#epaycustomer-class)
    * [Example](#epaycustomer-class-example)
    * [Parameters](#epaycustomer-class-parameters)  
4. [EpayTransaction Class](#epaytransaction-class)
    * [Example](#epaytransaction-class-example)
    * [Parameters](#epaytransaction-class-parameters)
5. [EpayBatch Class](#epaybatch-class)
    * [Example](#epaybatch-class-example)
    * [Parameters](#epaybatch-class-parameters)
6. [EpayProduct Class](#epayproduct-class)
    * [Example](#epayproduct-class-example)
    * [Parameters](#epayproduct-class-parameters)
7. [EpayCategory Class](#epaycategory-class)
    * [Example](#epaycategory-class-example)
    * [Parameters](#epaycategory-class-parameters)
8. [EpayInventory Class](#epayinventory-class)
    * [Example](#epayinventory-class-example)
    * [Parameters](#epayinventory-class-parameters)

<a name="requirements"></a>
## Requirements

This library uses PHP 7.4+ and Laravel 6+


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
<a name="epaycustomer-class"></a>
## EpayCustomer Class

The EpayCustomer Class handles the creation of the Customer object and the associated api calls.

<a name="epaycustomer-class-example"></a>
### Example 
#### (note: there are two ways to instantiate the epay classes, you can pass an array/object with the paramters or you can instantiate an empty class and manually set the parameters as needed.  Both will not always be shown in the subsequent examples.)

```php
$params = ['custkey'=>'asdf'];
$customer = new EpayCustomer($params);

return $customer->getCustomer();
```
OR
```php
$customer = new EpayCustomer();
$customer->custkey = 'asdf';

return $customer->getCustomer();
```
#### getCustomer()

In both the examples above, the EpayCustomer object is created and the Customer Key (custkey) parameter is set.  With that set, the getCustomer method can be called, returning the customer object from USAePay;

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
 
### EpayCustomer Methods w/ default required params

#### 	listcustomers()
* Required : `none`

#### 	getCustomer()
* Required : `custkey`

#### 	addCustomer()
* Required : `company (if no first_name && last_name), first_name (if no company), last_name (if no company)`

#### 	updateCustomer()
* Required : `custkey`

#### 	deleteCustomer()
* Required : `custkey`

<a name="epaytransaction-class"></a>
## EpayTransaction Class

The EpayTransaction Class handles the creation of the Transaction object and the associated api calls.

<a name="epaytransaction-class-example"></a>
### Example

```php
$quantumView = new Ups\QuantumView($accessKey, $userId, $password);

try {
	// Get the subscription for all events for the last hour
	$events = $quantumView->getSubscription(null, (time() - 3600));

	foreach($events as $event) {
		// Your code here
		echo $event->Type;
	}

} catch (Exception $e) {
	var_dump($e);
}
```

<a name="epaytransaction-class-parameters"></a>
### Parameters

EpayTransaction parameters are:

* `command` String - The Transaction command, required for all except get/list
* `trankey` String - required on get, required on authorize/capture if refnum is not present
* `refnum` String - required on authorize/capture if trankey is not present
* `invoice` String
* `ponum` String
* `orderid` String
* `description` String 
* `comments` String
* `email` String
* `merchemailaddr` String
* `amount` Float - required for sale/refund/authorize
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

<a name="epaybatch-class"></a>
## EpayBatch Class

The EpayBatch Class allow you to track a shipment using the UPS EpayBatch API.

<a name="epaybatch-class-example"></a>
### Example using EpayBatch Number / Mail Innovations tracking number

```php
$tracking = new Ups\Tracking($accessKey, $userId, $password);

try {
	$shipment = $tracking->track('TRACKING NUMBER');

	foreach($shipment->Package->Activity as $activity) {
		var_dump($activity);
	}

} catch (Exception $e) {
	var_dump($e);
}
```

<a name="epaybatch-class-parameters"></a>
### Parameters

Tracking parameters are:

 * `trackingNumber` The package’s tracking number.
 * `requestOption` Optional processing. For Mail Innovations the only valid options are Last Activity and All activity.

<a name="epaybatch-class-example"></a>
### Example using Reference Number

```php
$tracking = new Ups\Tracking($accessKey, $userId, $password);

try {
    $shipment = $tracking->trackByReference('REFERENCE NUMBER');

    foreach($shipment->Package->Activity as $activity) {
        var_dump($activity);
    }

} catch (Exception $e) {
    var_dump($e);
}
```
<a name="epaybatch-class-parameters"></a>
### Parameters

Tracking parameters are:

 * `referenceNumber` The ability to track any UPS package or shipment by reference number. Reference numbers can be a purchase order number, job number, etc. Reference Number is supplied when generating a shipment.
 * `requestOption` Optional processing. For Mail Innovations the only valid options are Last Activity and All activity.

<a name="epaybatch-class-example"></a>
### Example using Reference Number with additional parameters

```php
$tracking = new Ups\Tracking($accessKey, $userId, $password);

$tracking->setShipperNumber('SHIPPER NUMBER');

$beginDate = new \DateTime('2016-01-01');
$endDate = new \DateTime('2016-01-31');

$tracking->setBeginDate($beginDate);
$tracking->setEndDate($endDate);

try {
    $shipment = $tracking->trackByReference('REFERENCE NUMBER');

    foreach($shipment->Package->Activity as $activity) {
        var_dump($activity);
    }

} catch (Exception $e) {
    var_dump($e);
}
```

The parameters shipperNumber, beginDate and endDate are optional. Either of the parameters can be set individually. These parameters can help to narrow the search field when tracking by reference, since it might happen that the reference number used is not unique. When using tracking by tracking number these parameters are not needed since the tracking number is unique.

<a name="epayproduct-class"></a>
## Rate Class

The Rate Class allow you to get shipment rates using the UPS Rate API.

<a name="epayproduct-class-example"></a>
### Example

```php
$rate = new Ups\Rate(
	$accessKey,
	$userId,
	$password
);

try {
    $shipment = new \Ups\Entity\Shipment();

    $shipperAddress = $shipment->getShipper()->getAddress();
    $shipperAddress->setPostalCode('99205');

    $address = new \Ups\Entity\Address();
    $address->setPostalCode('99205');
    $shipFrom = new \Ups\Entity\ShipFrom();
    $shipFrom->setAddress($address);

    $shipment->setShipFrom($shipFrom);

    $shipTo = $shipment->getShipTo();
    $shipTo->setCompanyName('Test Ship To');
    $shipToAddress = $shipTo->getAddress();
    $shipToAddress->setPostalCode('99205');

    $package = new \Ups\Entity\Package();
    $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
    $package->getPackageWeight()->setWeight(10);
    
    // if you need this (depends of the shipper country)
    $weightUnit = new \Ups\Entity\UnitOfMeasurement;
    $weightUnit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_KGS);
    $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

    $dimensions = new \Ups\Entity\Dimensions();
    $dimensions->setHeight(10);
    $dimensions->setWidth(10);
    $dimensions->setLength(10);

    $unit = new \Ups\Entity\UnitOfMeasurement;
    $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

    $dimensions->setUnitOfMeasurement($unit);
    $package->setDimensions($dimensions);

    $shipment->addPackage($package);

    var_dump($rate->getRate($shipment));
} catch (Exception $e) {
    var_dump($e);
}
```
<a name="epayproduct-class-parameters"></a>
### Parameters

 * `rateRequest` Mandatory. rateRequest Object with shipment details

This Rate class is not finished yet! Parameter should be added when it will be finished.

<a name="epaycategory-class"></a>
## RateTimeInTransit Class

The RateTimeInTransit Class allow you to get shipment rates like the Rate Class, but the response will also include 
TimeInTransit data.

<a name="epaycategory-class-example"></a>
### Example

```php
$rate = new Ups\RateTimeInTransit(
	$accessKey,
	$userId,
	$password
);

try {
    $shipment = new \Ups\Entity\Shipment();

    $shipperAddress = $shipment->getShipper()->getAddress();
    $shipperAddress->setPostalCode('99205');

    $address = new \Ups\Entity\Address();
    $address->setPostalCode('99205');
    $shipFrom = new \Ups\Entity\ShipFrom();
    $shipFrom->setAddress($address);

    $shipment->setShipFrom($shipFrom);

    $shipTo = $shipment->getShipTo();
    $shipTo->setCompanyName('Test Ship To');
    $shipToAddress = $shipTo->getAddress();
    $shipToAddress->setPostalCode('99205');

    $package = new \Ups\Entity\Package();
    $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
    $package->getPackageWeight()->setWeight(10);
    
    // if you need this (depends of the shipper country)
    $weightUnit = new \Ups\Entity\UnitOfMeasurement;
    $weightUnit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_KGS);
    $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

    $dimensions = new \Ups\Entity\Dimensions();
    $dimensions->setHeight(10);
    $dimensions->setWidth(10);
    $dimensions->setLength(10);

    $unit = new \Ups\Entity\UnitOfMeasurement;
    $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

    $dimensions->setUnitOfMeasurement($unit);
    $package->setDimensions($dimensions);

    $shipment->addPackage($package);

    $deliveryTimeInformation = new \Ups\Entity\DeliveryTimeInformation();
    $deliveryTimeInformation->setPackageBillType(\Ups\Entity\DeliveryTimeInformation::PBT_NON_DOCUMENT);
    
    $pickup = new \Ups\Entity\Pickup();
    $pickup->setDate("20170520");
    $pickup->setTime("160000");
    $shipment->setDeliveryTimeInformation($deliveryTimeInformation);

    var_dump($rate->shopRatesTimeInTransit($shipment));
} catch (Exception $e) {
    var_dump($e);
}
```
<a name="epaycategory-class-parameters"></a>
### Parameters

 * `rateRequest` Mandatory. rateRequest Object with shipment details

This RateTimeInTransit extends the Rate class which is not finished yet! Parameter should be added when it will be finished.

<a name="epayinventory-class"></a>
## TimeInTransit Class

The TimeInTransit Class allow you to get all transit times using the UPS TimeInTransit API.

<a name="epayinventory-class-example"></a>
### Example

```php
$timeInTransit = new Ups\TimeInTransit($access, $userid, $passwd);

try {
    $request = new \Ups\Entity\TimeInTransitRequest;

    // Addresses
    $from = new \Ups\Entity\AddressArtifactFormat;
    $from->setPoliticalDivision3('Amsterdam');
    $from->setPostcodePrimaryLow('1000AA');
    $from->setCountryCode('NL');
    $request->setTransitFrom($from);

    $to = new \Ups\Entity\AddressArtifactFormat;
    $to->setPoliticalDivision3('Amsterdam');
    $to->setPostcodePrimaryLow('1000AA');
    $to->setCountryCode('NL');
    $request->setTransitTo($to);

    // Weight
    $shipmentWeight = new \Ups\Entity\ShipmentWeight;
    $shipmentWeight->setWeight($totalWeight);
    $unit = new \Ups\Entity\UnitOfMeasurement;
    $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_KGS);
    $shipmentWeight->setUnitOfMeasurement($unit);
    $request->setShipmentWeight($shipmentWeight);

    // Packages
    $request->setTotalPackagesInShipment(2);

    // InvoiceLines
    $invoiceLineTotal = new \Ups\Entity\InvoiceLineTotal;
    $invoiceLineTotal->setMonetaryValue(100.00);
    $invoiceLineTotal->setCurrencyCode('EUR');
    $request->setInvoiceLineTotal($invoiceLineTotal);

    // Pickup date
    $request->setPickupDate(new DateTime);

    // Get data
    $times = $timeInTransit->getTimeInTransit($request);

	foreach($times->ServiceSummary as $serviceSummary) {
		var_dump($serviceSummary);
	}

} catch (Exception $e) {
    var_dump($e);
}
```

<a name="epayinventory-class-parameters"></a>
### Parameters

 * `timeInTransitRequest` Mandatory. timeInTransitRequest Object with shipment details, see example above.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Credits

- [Aaron VanLaan][link-author]
- [All Contributors][link-contributors]

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
[link-contributors]: ../../contributors