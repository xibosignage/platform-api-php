# PHP Library for the Xibo Platform API

&copy; Spring Signage Ltd 2017

This is a PHP library for the Spring Signage Xibo Platform API. You can sign up for an account 
[here](https://app.xibo.org.uk). The API is accessible to any customer holding a valid Reseller Account.

User Documentation for the API can be found in the 
[Xibo Community KB](https://community.xibo.org.uk/t/xibo-platform-api/4196).

## Requirements
PHP 5.4 and later

## Composer
You can install the library via [Composer](http://getcomposer.org/). Add this to your `composer.json`:
```
{
  "require": {
    "xibosignage/platform-api-php": "1.*"
  }
}
```

Then install with:

```
composer install
```

## Usage
Please refer to the `/tests` folder for usage examples.

## Token Storage
An `access_token` lives as long as the script using the library and will automatically renew on expiry.
