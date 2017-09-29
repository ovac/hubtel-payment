# SendMoney

#### Introduction

The _SendMoney_ class allows you to send money from your php application by providing a fluent syntax for building the query to be sent to the Hubtel's Api.

Before getting started, be sure to have a _Config_ object that will be injected into the instance when it will be executed. [Check out this documentation for how to setup the _Config_](/Config)

## Using the SendMoney Class

The send money api can be consumed using a configuration instance with valid data from an existing Hubtel account.

#### The SendMoney class exposes several methods that can be chained to each other for fluent configuration of the params.

- [to](#method-to)
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
use OVAC\HubtelPayment\Api\Transaction\SendMoney;

public function someClass(Config $config)
{
    $sendMoney = SendMoney::to('0553577261')          //- The phone number to send the prompt to.
                ->amount(100.00)                    //- The exact amount value of the transaction
                ->description('Online Purchase')    //- Description of the transaction.
                ->customerEmail('admin@ovac4u.com') //- Name of the person making the payment.
                ->callback('http://ovac4u.com/pay') //- The URL to send callback after payment. 
                ->channel('mtn-gh');                //- The mobile network Channel.
                
    $sendMoney->injectConfig($config)               //- Inject the configuration
              ->run();                              //- Run the transaction after required data.
}
```


## Let's Break it down
---
<a name="method-to"></a>
#### `to(number)` {#SendMoney-method}
The `to` method can be called statically, thus creates an instance of the send money class. The to method takes the phone number that the money is going to be sent to:

```php
    use OVAC\HubtelPayment\Api\Transaction\SendMoney;

    // Sets the receiver of the funds and returns the sendMoney
    // So that it can be changed to other parameter setup methods.
    $sendMoney = SendMoney::to('0553577261');
```

The `to` method can also be chained to an instance that already exists and 

```php
    use OVAC\HubtelPayment\Api\Transaction\SendMoney;

    $sendMoney = SendMoney::to('0553577261');

    // This will set the number that the mobile money will be sent to
    // If a number was previously set, it will be updated.
    $sendMoney->to('0553577261');
```

<a name="method-amount"></a>
#### `amount(number)` {#SendMoney-method}
The `amount` method can be called statically, thus creates an instance of the send money class. The to method takes the value of the transaction and returns the SendMoney instance:

```php
    
    use OVAC\HubtelPayment\Api\Transaction\SendMoney;

    // Sets the receiver of the funds and returns the sendMoney
    // So that it can be changed to other parameter setup methods.
    $sendMoney = SendMoney::amount(100.90);
```

The `amount` method can also be chained to an instance that already exists and 

```php
    
    use OVAC\HubtelPayment\Api\Transaction\SendMoney;

    $sendMoney = SendMoney::amount('0553577261');

    // This will set amount of .
    // but if a number was previously set, it will be updated.
    $sendMoney->amount('0553577261');
```

<a name="method-description"></a>
#### `description(string)` {#SendMoney-method}
The `description` method takes in a string of the description of the transaction:

```php
    $sendMoney->description('Money for rent'); //Describe the transaction
```

<a name="method-customerEmail"></a>
#### `customerEmail(string)` {#SendMoney-method}
The `customerEmail` method takes in a string of the Receiver's Email address:

```php
    $sendMoney->customerEmail('Money for rent'); //Email of the receiver
```

<a name="method-customerName"></a>
#### `customerName(string)` {#SendMoney-method}
The `customerName` method takes in a string of the Receiver's Name:

```php
    $sendMoney->customerName('Money for rent'); //Name of the receiver
```

<a name="method-setCustomer"></a>
#### `setCustomer(array)` {#SendMoney-method}
The `setCustomer` The `customerName` method takes in an `array` of the key and value of the customer's info
This can be used instead of calling `customerName` and `customerEmail` seperately.

```php
    // This way, all customer details are set at once.
    $sendMoney = SendMoney::amount(100.00)->setCustomer([
        'name' => 'Ariama Victor',
        'email' => 'contact@ovac4u.com',
        'phone' => '0553577261'
    ]);


    // With this method, you can set only one or two instead of all three, so this will also work
    $sendMoney = SendMoney::to('0553577261')
        ->setCustomer([
            'name' => 'Ariama Victor',
            'email' => 'contact@ovac4u.com',
        ]);
```

<a name="method-callbackOnSuccess"></a>
#### `callbackOnSuccess(string)` {#SendMoney-method}
The `callbackOnSuccess` method takes in a url to which Hubtel will send a cllback after a successful payment.

```php
    $sendMoney->callbackOnSuccess('http://your_url_for_hubtel_callback_on_success');
```

<a name="method-callbackOnError"></a>
#### `callbackOnError(string)` {#SendMoney-method}
The `callbackOnError` method takes in a url to which Hubtel will send a callback to if a user does not complete the payment.
or if there is no money or not enough money in the account of the user.

```php
    $sendMoney->callbackOnError('http://your_url_for_hubtel_callback_on_error');
```


<a name="method-setCallback"></a>
#### `setCallback(array)` {#SendMoney-method}
The `setCallback` method takes in an `array` of the key and value of the callback info
This can be used instead of calling `callBackOnError` and `callBackOnSuccess` seperately.

```php

    use OVAC\HubtelPayment\Api\Transaction\SendMoney;

    // This way, all customer details are set at once.
    $sendMoney = SendMoney::amount(100.00)->setCallback([
        'success' => 'http://your_url_for_hubtel_callback_on_success',
        'error' => 'http://your_url_for_hubtel_callback_on_error',
    ]);
```


<a name="method-callback"></a>
#### `callback(array)` {#SendMoney-method}
The `callback` method takes in a `string` the url to send callback to both for success and error.
On the route handling this url, you could use an `if` statement to determine if the callback was successful or an error.

```php
    // This way, all customer details are set at once.
    $sendMoney = SendMoney::amount(100.00)->callback([
        'success' => 'http://your_url_for_hubtel_callback_on_success',
        'error' => 'http://your_url_for_hubtel_callback_on_error',
    ]);
```

<a name="method-run"></a>
#### `run(array)` {#SendMoney-method}
The `run` method can be called after all the parameters have been provided. it creates the call to the Hubtel server.
Note: Some parameters are required by the hubtel server and must be available before the run method is called. The client will throw an error if the required paramseters have not been setup. They have been listed at the bottom of this page. You can also checkout [Hubtel SendMoney Request Params]() for the required and optional params.

```php
    // The call to the SendMoney Run method will return a Json Response from the hubtel API Server.
    $sendMoney->run();
```


## Generic Methods
This class inherits and implements expected generic methods for the setters and getters
You can [checkout the full API here](https://ovac4u.com/packages/ovac-hubtel-payment/api)
