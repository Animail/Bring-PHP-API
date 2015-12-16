# Bring PHP API

This PHP wrapper is not supported by Bring, but as of Dec 2015 they do not offer a PHP alternative. Based on the [developer documentation](http://developer.bring.com/).

## Installing

With Composer:

```
composer require animail/bring-api
```

Voila!

## How to use it

### Initialize

```php
use \Animail\BringApi;

// ...

$api_uid = 'john.doe@example.com';
$api_key = '1234abc-abcd-1234-5678-abcd1234abcd';
$my_website_url = 'https://example.com/';
$bring = new BringApi($api_uid, $api_key, $my_website_url);

// Don't want to authenticate?
$bring = new BringApi();
```

### Find shipment by reference, package number or shipment number

The `track()` method wraps the [Tracking API](http://developer.bring.com/api/tracking/) and always returns an array, including when the shipment(s) could not be found. Unless there was an API error, in which case we'll throw all kinds of fun `\Animail\BringApiException`s.

```php

// Shipment number
$consignmentSet = $bring->track('73325389952521130'); // array('consignmentSet' => array())

// Package number
$consignmentSet = $bring->track('CT797294851NO'); // array('consignmentSet' => array())

// Reference (this is usually your internal ordernumber or shipmentID)
$consignmentSet = $bring->track('1234'); // array('consignmentSet' => array())

```

### Catching exceptions

** Catch everything in the same place **
```php
try {
  $bring = new BringApi('', '', '');
} catch (BringApiException $e) {
  // All our exception types extend the BringApiException class
}
```

** Only catch errors from the API **
```php
try {
  $bring = new BringApi('', '', '');
  $results = $bring->track('boobar');
} catch (BringApiErrorException $e) {

}
```

** Separate handlers for different types **
```php
try {
  $bring = new BringApi('', '', '');
  $results = $bring->track('boobar');
} catch (BringApiClientException $e) {
  // Issues with the client. Guzzle for some reason threw an error.
} catch (BringApiErrorException $e) {

} catch (BringApiException $e) {
  // This one will never be called unless we add more exception types in the future
}
```

## Contributing

We love open source software and would love to see pull requests. We're *trying* to be [PSR-4](http://www.php-fig.org/psr/psr-4/) compliant but don't have many other requirements.
