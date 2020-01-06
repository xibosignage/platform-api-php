# PHP Library for the Xibo Platform API

&copy; Xibo Signage Ltd 2020

This is a PHP library for the Xibo Signage Xibo Platform API. 

The API is accessible to any channel partner.



## Documentation

Please see the `/docs` folder for information on how to use this library. Further usage examples can be found in the `/tests` folder.



## Requirements

PHP 5.4 and later



## Composer

You can install the library via [Composer](http://getcomposer.org/). Add this to your `composer.json`:
```
{
  "require": {
    "xibosignage/platform-api-php": "3.*"
  }
}
```

Then install with:

```
composer install
```



## Token Storage

An `access_token` lives as long as the script using the library and will automatically renew on expiry.





# Integration Tests

This library has some basic integration tests, if you want to run these you are welcome to do so. Please be aware that transactions will be executed in your Test portal account.



Create an `env` file containing your clientId/secret.

```env
XIBO_PLATFORM_CLIENT_ID=
XIBO_PLATFORM_CLIENT_SECRET=
```



Build a Docker image and tag it

```bash
docker build -t phpunit-test .
```



Run the tests

```bash
docker run --env-file config.env -it --rm --name phpunit phpunit-test
```

