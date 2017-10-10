# Installation

To install OVAC\Hubtel-Payment you need:

 - PHP 5.4+
 - [Composer](https://getcomposer.org/)

OVAC\Hubtel-Payment is available on Packagist, so the only thing you need to do is to add it as a dependency for your project.

That can be done by running following command in your project folder:

```shell
composer require ovac/hubtel-payment
```

As alternative you can directly edit your `composer.json` by adding:

```json
{
  "require": {
    "ovac/hubtel-payment": "~0"
  }
}
```

After that, only be sure to include composer autoload file:

```php
require 'vendor/autoload.php';
```

## Dependencies

OVAC\Hubtel-Payment needs 1 community powered quality libraries to work:

 - [Guzzle](http://docs.guzzlephp.org/en/stable/) (MIT)

It will be installed for you by Composer.

## Development Dependencies

As this package depends on the current stable release of PHPUnit (v6.3+) for testing, when installed in development mode, OVAC\Hubtel-Payment will only work on PHP 7+ because PHPunit requires . This is because the and also requires:

 - [PHPUnit](https://phpunit.de) (MIT)
 - [Mockery](http://docs.mockery.io/en/latest/) (BSD-3-CLAUSE)
 - [PHPMD - PHP Mess Detector](https://phpmd.org/) (BSD 3-clause)
 - [PHP-Coveralls](https://github.com/satooshi/php-coveralls) (MIT)
 - [PHP_CodeSniffer](https://www.squizlabs.com/php-codesniffer) (MIT)
 - [PHP Copy/Paste Detector (PHPCPD)](https://github.com/sebastianbergmann/phpcpd) (BSD 3-clause)
 - [Symfony2 PHP_CodeSniffer Coding Standard](https://github.com/leaphub/phpcs-symfony2-standard) (MIT)