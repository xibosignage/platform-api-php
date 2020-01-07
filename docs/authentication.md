## Authentication

The Xibo Signage API uses an oAuth2 Authorisation Server with Client Credential Grant in order to Authenticate requests to the API. Client Credentials are available from the My Account section of the Web UI and should be kept secret.

Using the PHP library, authentication is taken care of for you when you create a Provider.

```php
$provider = new \Xibo\Platform\Provider\XiboPlatform([
    'clientId' => $clientId,
    'clientSecret' => $clientSecret,
    'mode' => 'TEST'
]);
```

The `mode` parameter can be either `LIVE` or `TEST` depending on which production mode you are targeting. Make sure you don't commit your `$clientId` or `$clientSecret` into source control - these should remain private.

Once you have a provider created, you can use it to make authenticated requests, for example to get details on your account:

```php
$provider->me();
```



### Using a web client

You can also authorise using a web client, such as curl. To do so your Client Credentials are exchanged with the Authorisation Server for an `access_token` via a POST request to the `access_token` endpoint.

```bash
curl -X POST \
  https://test.xibo.org.uk/authorize/access_token \
  -H 'cache-control: no-cache' \
  -d 'client_id=your_client_id&client_secret=your_client_secret&grant_type=client_credentials'
```

The response will contain an access token for use with the current session and an expires timeout in seconds which you can use to determine when you will need to request another access token.

```json
{
  "access_token": "T6dqCj3rZ24TeG73nzykrMKJwsiRsqfdlO1zC66a",
  "token_type": "Bearer",
  "expires_in": 3600
}
```



The `access_token` is used for all other requests to the Resource Server and should be sent as a HTTP Authorisation header.



## Resource Server

All further API calls are secured behind the resource server via the URL:

```
https://test.xibo.org.uk/api
```

All responses will have a HTTP status of either 200 or 400/500 (success or failure), with the same code embedded in the JSON response. Errors will have an additional "message" parameter providing a human readable error message.

For example:

```json
{
    "error": 422,
    "message": "Missing Line Items",
    "property": "lineItems",
    "help": null
}
```



To get information about the user who owns the access tokens, you would use the provider:

```php
$provider->me();
```



Of using a web client issue the following request:

```bash
curl -X GET \
  https://test.xibo.org.uk/api/user/account \
  -H 'Accept: */*' \
  -H 'Accept-Encoding: gzip, deflate' \
  -H 'Authorization: Bearer access_token' \
  -H 'Cache-Control: no-cache' \
  -H 'Connection: keep-alive' \
  -H 'Host: test.xibo.org.uk' \
  -H 'cache-control: no-cache'
```



[Continue to Checkout](docs/checkout.md).

