# Bring PHP API

This PHP wrapper is not supported by Bring, but as of the time of writing they do not offer a PHP alternative. Based on the [developer documentation](http://developer.bring.com/).

# Installing

With Composer:

```
composer require animail/bring-api
```

Voila!

# How to use it

### Initialize

```php
use \Animail\BringApi;

// ...

$bring = new BringApi;
$bring->setUid('john.doe@example.com');
$bring->setKey('1234abc-abcd-1234-5678-abcd1234abcd');
$bring->setClientUrl('https://example.com/');
```

### Find shipment by reference, package number or shipment number

The `track()` method wraps the [Tracking API](http://developer.bring.com/api/tracking/) and always returns an array, including when the shipment(s) could not be found. Unless there was an API error, in which case we'll throw all kinds of fun `\Animail\BringApiException`s.

```php

// Shipment number
$consignmentSet = $bring->track('73325389952521130');

// Package number
$consignmentSet = $bring->track('CT797294851NO');

// Reference (this is usually your internal ordernumber or shipmentID)
$consignmentSet = $bring->track('1234');

```

# Contributing

We love open source software and would love to see pull requests. We're *trying* to be [PSR-4](http://www.php-fig.org/psr/psr-4/) compliant but don't have many other requirements.
