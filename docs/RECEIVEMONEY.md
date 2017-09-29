# ReceiveMoney

#### Introduction

The _ReceiveMoney_ class allows you to receive money from your php application by providing a fluent syntax for building the query to be sent to the Hubtel's Api. When configured correctly, it sends a prompt to the intended number making the payment.

Before getting started, be sure to have a _Config_ object that will be injected into the instance when it will be executed. [Check out this documentation for how to setup the _Config_](/CONFIG.md)

## Using the ReceiveMoney Class

The send money api can be consumed using a configuration instance with valid data from an existing Hubtel account.

#### The ReceiveMoney class exposes several methods that can be chained to each other for fluent configuration of the parameters required by the hubtel api.

- [from](#method-from)
- [amount](#method-amount)
- [description](#method-description)
- [channel](#method-channel)
- [customerEmail](#method-customerEmail)
- [customerName](#method-customerName)
- [setCustomer](#method-setCustomer)
- [callbackOnSuccess](#method-callbackOnSuccess)
- [callbackOnError](#method-callbackOnError)
- [setCallback](#method-setCallback)
- [callback](#method-callback)

##### The [`run`](#method-run) method must be called after the configuration chain is complete, in order to execute the command and place a call to the hubtel api.
- [run](#method-run)



## Putting it all together.

Putting it all together, we will place a call to the Hubtel Api and return a JSON data or throw an error if it was not successful.

You can checkout the expected response types here.

```php
<?php

use OVAC\HubtelPayment\Config;
use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;

public function someClass(Config $config)
{
    $receiveMoney = ReceiveMoney::from('0553577261') //- The phone number to send the prompt to.
                ->amount(100.00)                    //- The exact amount value of the transaction
                ->description('Online Purchase')    //- Description of the transaction.
                ->customerEmail('admin@ovac4u.com') //- Name of the person making the payment.
                ->callback('http://ovac4u.com/pay') //- The URL to send callback after payment. 
                ->channel('mtn-gh');                //- The mobile network Channel.
                
    $receiveMoney->injectConfig($config)            //- Inject the configuration
              ->run();                              //- Run the transaction after required data.
}
```


## Let's Break it down
---
<a name="method-from"></a>
#### `from(number)` {#ReceiveMoney-method}
The `from` method can be called statically, thus creates an instance of the receive money class. The `from` method takes the phone number that is making the payment:

```php
    use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;

    // Sets the number to bill from.
    // So that it can be changed to other parameter setup methods.
    $receiveMoney = ReceiveMoney::from('0553577261');
```

The `to` method can also be chained to an instance that already exists and 

```php
    use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;

    $receiveMoney = ReceiveMoney::from('0553577261');

    // This will set the number that the mobile that will receive the payment prompt
    // If a number was previously set, it will be updated.
    $receiveMoney->from('0553577261');
```

<a name="method-amount"></a>
#### `amount(number)` {#ReceiveMoney-method}
The `amount` method can be called statically, thus creates an instance of the receive money class. The `amount` method takes the value of the transaction and returns the ReceiveMoney instance:

```php
    
    use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;

    // Sets the amount of money that will be billed to the client
    $receiveMoney = ReceiveMoney::amount(100.90);
```

The `amount` method can also be chained to an instance that already exists and 

```php
    
    use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;

    $receiveMoney = ReceiveMoney::amount('0553577261');

    // This will set amount of .
    // but if a number was previously set, it will be updated.
    $receiveMoney->amount('0553577261');
```

<a name="method-description"></a>
#### `description(string)` {#ReceiveMoney-method}
The `description` method takes in a string of the description of the transaction:

```php
    $receiveMoney->description('Money for rent'); //Describe the transaction
```

<a name="method-customerEmail"></a>
#### `customerEmail(string)` {#ReceiveMoney-method}
The `customerEmail` method takes in a string of the Mobile Money (Payer) Sender's Email address:

```php
    $receiveMoney->customerEmail('contact@ovac4u.com'); //Email of the Sender (Payer)
```

<a name="method-customerName"></a>
<!--
currentMenu: "receivemoney"
currentSection: "classes"
title: "Receive Money"
-->

#### `customerName(string)` {#ReceiveMoney-method}
The `customerName` method takes in a string of the Receiver's Name:

```php
    $receiveMoney->customerName('John Doe'); //Name of the Sender (Payer)
```

<a name="method-setCustomer"></a>
#### `setCustomer(array)` {#ReceiveMoney-method}
The `setCustomer` The `customerName` method takes in an `array` of the key and value of the customer's info
This can be used instead of calling `customerName` and `customerEmail` seperately.

```php
    // This way, all customer details are set at once.
    $receiveMoney = ReceiveMoney::amount(100.00)->setCustomer([
        'name' => 'Ariama Victor',
        'email' => 'contact@ovac4u.com',
        'phone' => '0553577261'
    ]);


    // With this method, you can set only one or two instead of all three, so this will also work
    $receiveMoney = ReceiveMoney::from('0553577261')
        ->setCustomer([
            'name' => 'Ariama Victor',
            'email' => 'contact@ovac4u.com',
        ]);
```

<a name="method-callbackOnSuccess"></a>
#### `callbackOnSuccess(string)` {#ReceiveMoney-method}
The `callbackOnSuccess` method takes in a url to which Hubtel will send a cllback after a successful payment.

```php
    $receiveMoney->callbackOnSuccess('http://your_url_for_hubtel_callback_on_success');
```

<a name="method-callbackOnError"></a>
#### `callbackOnError(string)` {#ReceiveMoney-method}
The `callbackOnError` method takes in a url to which Hubtel will send a callback to if a user does not complete the payment.
or if there is no money or not enough money in the account of the user.

```php
    $receiveMoney->callbackOnError('http://your_url_for_hubtel_callback_on_error');
```


<a name="method-setCallback"></a>
#### `setCallback(array)` {#ReceiveMoney-method}
The `setCallback` method takes in an `array` of the key and value of the callback info
This can be used instead of calling `callBackOnError` and `callBackOnSuccess` seperately.

```php

    use OVAC\HubtelPayment\Api\Transaction\ReceiveMoney;

    // This way, all customer details are set at once.
    $receiveMoney = ReceiveMoney::amount(100.00)->setCallback([
        'success' => 'http://your_url_for_hubtel_callback_on_success',
        'error' => 'http://your_url_for_hubtel_callback_on_error',
    ]);
```


<a name="method-callback"></a>
#### `callback(array)` {#ReceiveMoney-method}
The `callback` method takes in a `string` the url to send callback to both for success and error.
On the route handling this url, you could use an `if` statement to determine if the callback was successful or an error occured.

```php
    // This way, all customer details are set at once.
    $receiveMoney = ReceiveMoney::amount(100.00)->callback([
        'success' => 'http://your_url_for_hubtel_callback_on_success',
        'error' => 'http://your_url_for_hubtel_callback_on_error',
    ]);
```

<a name="method-run"></a>
#### `run(array)` {#ReceiveMoney-method}
The `run` method can be called after all the parameters have been provided. it creates the call to the Hubtel server.
Note: Some parameters are required by the hubtel server and must be available before the run method is called. The client will throw an error if the required paramseters have not been setup. They have been listed at the bottom of this page. You can also checkout [Hubtel ReceiveMoney Request Params]() for the required and optional params.

```php
    // The call to the ReceiveMoney Run method will return a Json Response from the hubtel API Server.
    $receiveMoney->run();
```

## Mass Assignment
The ReceiveMoney method supports mass assigment upon creating a new instance of the class. The Mass assinable values can be passed into the constructor as an arguement in a cascading array format as follows:

```php
    $receiveMoney = new ReceiveMoney(array(
        'customer' => array(
            'name' => $this->customerName,
            'email' => $this->customerEmail,
            'phone' => $this->customerMsisdn,
        ),
        'callback' => array(
            'success' => $this->primaryCallbackURL,
            'error' => $this->secondaryCallbackURL,
        ),
        'description' => $this->description,
        'clientReference' => $this->clientReference,
        'channel' => $this->channel,
        'token' => $this->token,
        'feesOnCustomer' => true,
    ));
    
    // This will run the transaction and prompt the phone number as an agent.
    $receiveMoney->run();
```

## Generic Methods
This class inherits and implements generic methods

You can [checkout the full API here](https://ovac4u.com/hubtel-payment-api)

