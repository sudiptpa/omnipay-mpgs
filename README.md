# Omnipay: MPGS

**Mastercard Payment Gateway Services driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements MPGS support for Omnipay.

[![StyleCI](https://styleci.io/repos/74269379/shield?style=flat&branch=master)](https://styleci.io/repos/74269379)
[![Latest Stable Version](https://poser.pugx.org/sudiptpa/omnipay-mpgs/v/stable?style=flat-square)](https://packagist.org/packages/sudiptpa/omnipay-mpgs)
[![Total Downloads](https://poser.pugx.org/sudiptpa/omnipay-mpgs/downloads?style=flat-square)](https://packagist.org/packages/sudiptpa/omnipay-mpgs)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/sudiptpa/omnipay-mpgs/master/LICENSE)

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "sudiptpa/omnipay-mpgs": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

#### Hosted Checkout

```php

$gateway = Omnipay::create('Mpgs_Hosted')
        ->setMerchantId(xxxxxxx)
        ->setApiPassword(xxxxxx)
        ->setApiUrlPrefix('https://na-gateway.mastercard.com');

```

##### Purchase Request

```php
try {
    $response = $gateway->purchase([
        'merchantName' => 'Test Merchant',
        'amount' => 10,
        'transactionId' => 1,
        'transactionReference' => 1,
        'currency' => 'AUD',
        'card' => new CreditCard([
            'billingFirstName' => 'First Name',
            'billingLastName' => 'Last Name',
            'email' => 'user@example.com',
            'billingPhone' => '1234567890',
            'billingAddress1' => 'Street',
            'billingCity' => 'City',
            'billingState' => 'State',
            'billingPostcode' => '03444',
            'billingCountry' => 'AUS',
        ]),
        'cancelUrl' => 'https://example.com/checkout/1/cancel',
        'returnUrl' => 'https://example.com/checkout/1/success',
        'notifyUrl' => 'https://example.com/checkout/1/notify',
    ]);

} catch (Exception $e) {
   // error
}

if ($response->isSuccessful()) {
    // $response->getSessionId();
}
```

##### Complete Purchase Request

```php
$response = $gateway->completePurchase([
    'orderId' => 1,
]);

if ($response && $response->isSuccessful() && $response->isCaptured()) {
    // successful
}

// handle error
```

##### Initiate Checkout

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Processing Payment</title>
  </head>
  <body>
    <div align="center">
        <h4>Processing payment ...</h4>
    </div>

    <script
        src="https://na-gateway.mastercard.com/static/checkout/checkout.min.js"
        data-error="https://example.com/checkout/1/cancel"
        data-beforeRedirect="Checkout.saveFormFields"
        data-afterRedirect="Checkout.restoreFormFields">
    </script>

    <script type="text/javascript">
        Checkout.configure({
          session: {
              id: session_id // pass the session id received from purchase request.
          }
        });

        Checkout.showPaymentPage();
    </script>
  </body>
</html>

```


For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Unit Testing

```
composer test

```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/sudiptpa/nabtransact/issues),
or better yet, fork the library and submit a pull request.
