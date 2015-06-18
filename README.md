# PHP Library for the Xibo Cloud API

&copy; Spring Signage Ltd 2015

This is a PHP library for the Spring Signage Xibo Cloud Platform. You can sign up for an account at https://springsignage.com/portal. The API is accessible to any customer holding a valid Reseller Account.

User Documentation for the API can be found at https://springsignage.freshdesk.com/support/solutions/folders/3000006270.

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

## Token Storage
The Cloud API uses an oAuth Client Credentials Grant to authenticate requests. This library represents an AccessToken with the following structure.

```
{
	"url": either the test/production endpoint
	"token", the token
	"timeout", the token timeout
}
```

These tokens should be stored locally and reused until the time out occurs, this is handled transparently by the library but a credential store **must** be provided.

The TokenStore implementation is simple, consisting of a save() and load() call to store/retrieve the AccessToken.

A simple example can be found in the `tests/` folder.