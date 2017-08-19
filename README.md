# OVAC Hubtel Payment
The best and most comphrensive PHP Client for consuming the Hubtel Payment API and for sending and receiving Mobile Money Payment from a php application with an elegant **Write as it sounds** syntax.

[![Build Status](https://travis-ci.org/ovac/hubtel-payment.svg?branch=master)](https://travis-ci.org/ovac/hubtel-payment) 
[![Coverage Status](https://coveralls.io/repos/github/ovac/hubtel-payment/badge.svg?branch=master)](https://coveralls.io/github/ovac/hubtel-payment?branch=master)
[![Latest Stable Version](https://poser.pugx.org/ovac/hubtel-payment/v/stable)](https://packagist.org/packages/ovac/hubtel-payment)
[![Total Downloads](https://poser.pugx.org/ovac/hubtel-payment/downloads)](https://packagist.org/packages/ovac/hubtel-payment)
[![License](https://poser.pugx.org/ovac/hubtel-payment/license)](https://packagist.org/packages/ovac/hubtel-payment)
[![Dependency Status](https://www.versioneye.com/user/projects/598fccd8368b081653c84e2e/badge.svg)](https://www.versioneye.com/user/projects/598fccd8368b081653c84e2e)

```md
 Follow me anywhere @ovac4u                         | GitHub
 _________                          _________       | Twitter
|   ___   |.-----.--.--.---.-.----.|  |  |.--.--.   | Facboook
|  |  _   ||  _  |  |  |  _  |  __||__    |  |  |   | Instagram
|  |______||_____|\___/|___._|____|   |__||_____|   | Github + @ovac
|_________|                        www.ovac4u.com   | Facebook + @ovacposts
```

## What is it?

OVAC/Hubtel-Payment is a comphrensive PHP client for consuming the Hubtel Mobile Money Payment server API. It's a full-on PHP toolbet sugar-coated by an elegant syntax directly inspired by the [Laravel framework](http://www.laravel.com).

It features a good set of methods and tests for accessing the Hubtel Mobile Money Payment with a **Write as it sounds** syntax. Oh also it's growing all the time.

What's the cherry on top? It wraps nicely around native Guzzlehttp client and uses most of PHP best practices in relation to usability and security. What does this mean? This meands that `Pay::receiveMoney()->from(0553577261)->run();` actually places a dynamic call behind the scene in a very secure manner using the phone number as the CustomerMsidn as required by the Hubtel's Mobile Money Receive Money api and propts the owner of the phone number as an agent.

## Install OVAC\Hubtel-Payment

To install OVAC\HubtelPayment library, simply run 
```
$ composer require ovac/hubtel-payment
```

## OVAC\Hubtel-Payment Basic Usage

First Obtain a Hubtel Developer Account Number, ClientID and ClientSecret from https://unity.hubtel.com/account/api-accounts-add

#### The ReceiveMoney class may be used send a prompt to the customer's phone to receive money like a mobile-money agent as follows:

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;

// First Create configuration with your Hubtel Developer Credentials
// The Account Number, ClientID and ClientSecret accordingly.
$config = new Config(Account_Nnumber, ClientId, ClientSecret);

$payment =  ReceiveMoney::from(0553577261)          //- The phone number to send the prompt to.
                ->amount(100.00)                    //- The exact amount value of the transaction
                ->desctiption('Online Purchase')    //- Description of the transaction.
                ->customerName('Ariama Victor')     //- Name of the person making the payment.
                ->callback('http://ovac4u.com/pay') //- The URL to send callback after payment.	
                ->channel('mtn-gh')                 //- The mobile network Channel.
                ->injectConfig($config)             //- Inject the configuration
                ->run();                            //- Run the transaction after required data.
```


#### The SendMoney class may also be used send money to any mobile money customer as follows:

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Api\Transaction\SendMoney;

// First Create configuration with your Hubtel Developer Credentials
// The Account Number, ClientID and ClientSecret accordingly.
$config = new Config(Account_Nnumber, ClientId, ClientSecret);

$payment = SendMoney::to(0553577261)                //- The phone number to send the prompt to.
                ->amount(100.00)                    //- The exact amount value of the transaction
                ->desctiption('Online Purchase')    //- Description of the transaction.
                ->customerEmail('admin@ovac4u.com') //- Name of the person making the payment.
                ->callback('http://ovac4u.com/pay') //- The URL to send callback after payment.	
                ->channel('mtn-gh')                 //- The mobile network Channel.
                ->injectConfig($config)             //- Inject the configuration
                ->run();                            //- Run the transaction after required data.
```


#### The Refund class may also refund money to a customer paid in a previous transaction:

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Api\Transaction\Refund;

// First Create configuration with your Hubtel Developer Credentials
// The Account Number, ClientID and ClientSecret accordingly.
$config = new Config(Account_Nnumber, ClientId, ClientSecret);

$payment = Refund::transactionId(1234)              //- The ID of the transaction to refund.
                ->amount(100.00)                    //- The exact amount value of the transaction
                ->clientReference('#11212')         //- A refeerence on your end.
                ->desctiption('Useless Purchase')   //- Description of the transaction.
                ->reason('No longer needs a pen')   //- Name of the person making the payment.
                ->full()                            //- Full or partial refund.
                ->injectConfig($config)             //- Inject the configuration
                ->run();                            //- Run the transaction after required data.
```

# Documentation

You can find a detailed summary of all classes and methods on the [official page](https://www.ovac4u.com/packages/hubtel-payment). The changelog is available in the CHANGELOG file.

You can find a detailed summary of all classes and methods in the repo's wiki or the official page. The changelog is available in the CHANGELOG file.

## Tests

if you have phpunit installed globally

```
$ vendor/bin/phpunit
```

or use the composer script

```
$ composer phpunit
```

#### Code analysis tools

***lint/checkstyle*** with phpcs:

```
$ composer phpcs
```

***mess detector*** with phpmd:

```
$ composer phpmd
```

***copy & paste detector*** with phpcpd:

```
$ composer phpcpd
```

***phpunit, lint, mess detector*** in one command:

```
$ composer test
```



## CI

A simple ci bash script exists under bin folder

```
$ bin/ci.sh
```

## Licence
* [Licence: MIT](https://github.com/ovac/hubtel-payment/licence)


## Reference
- [Official Page](https://www.ovac4u.com/packages/hubtel-payment)
- [Official Repo: Github](https://www.github.com/ovac/hubtel-payment)

- [Hubtel Merchant Payment Reference](https://developers.hubtel.com/documentations/merchant-account-api)
- [Laravel framework](http://laravel.com)

- [Repo's wiki](https://github.com/ovac/hubtel-payment/wiki/_pages)
- [LICENCE: MIT](https://github.com/ovac/hubtel-payment/blob/licence)
- [CHANGELOG](https://github.com/ovac/hubtel-payment/blob/master/CHANGELOG.md)
