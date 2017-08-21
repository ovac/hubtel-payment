# Config

_Config_ is the configuration class used by the _Api_ and holds the developer authentication data. It is required by the client handler to authenticate the http calls to the Hubtel Api.

#### Creating a Config.

The Config class only accepts three arguments :

+ The Hubtel Account Number
+ The Hubtel ClientID
+ The Hubtel ClientSecret

The arguments must be passed in accordingly to the Hubtel Config as follows:
```php
	use OVAC\HubtelPayment\Config;

	new Config(AccountNumber, ClientId, ClientSecret);
```

The data on this Client ID and ClientSecret above can be obtained from any existing or new Hubtel account by creating a developer api application as follows:

First navigate to the Hubtel Accounts Api page at https://unity.hubtel.com/account/api-accounts
![](http://res.cloudinary.com/ovac/image/upload/v1503168307/Screen_Shot_2017-08-19_at_6.39.35_PM_ful74t.png)

Click on the **add application** button.
![](http://res.cloudinary.com/ovac/image/upload/v1503168308/Screen_Shot_2017-08-19_at_6.40.00_PM_hb8yv2.png)

Select *Http Rest Api* as the Api type and provide a description of the application and then hit save.
![](http://res.cloudinary.com/ovac/image/upload/v1503168309/Screen_Shot_2017-08-19_at_6.40.31_PM_kufajk.png)

After hitting the save button, The ClientID and ClientSecret will be revealed as shown below.
![](http://res.cloudinary.com/ovac/image/upload/v1503168310/Screen_Shot_2017-08-19_at_6.41.57_PM_axctjs.png)

The Account Number can also be found at https://unity.hubtel.com/merchantaccount/dashboard
![](http://res.cloudinary.com/ovac/image/upload/v1503170598/Screen_Shot_2017-08-19_at_7.22.29_PM_obfhb9.png)

### Example #1 using the data from the Hubtel account shown above.

```php
	use OVAC\HubtelPayment\Config;

	$config = new Config('HM2707170067', 'ukoqgisb', 'tfbfugam');

```

The config can now be injected into a call to any of the _Transaction_ class as shown [here][ReceiveMoney]


## properties

The config object has setters and getters that allow you to manipulate the properties of the instance subject.


[ReceiveMoney]: RECEIVEMONEY.md