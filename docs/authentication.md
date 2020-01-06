## Authentication

The Xibo Signage API uses an oAuth2 Authorisation Server with Client Credential Grant in order to Authenticate requests to the API. Client Credentials are available from the My Account section of the Web UI and should be kept secret.

The Client Credentials are exchanged with the Authorisation Server for an access_token, this is done using a POST request to the `access_token` endpoint.

```
https://xibo.org.uk/authorize/access_token
     
POST
grant_type=client_credentials
client_id=<your client id>
client_secret=<your client secret>
```

The response will contain an access token for use with the current session and an expiry time which you can use to determine when you will need to request another access token.

```json
{
  "access_token": "T6dqCj3rZ24TeG73nzykrMKJwsiRsqfdlO1zC66a",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

The access_token is used for all other requests to the Resource Server and can be send as a HTTP Authorisation header or appended to the API URL as shown below.

```
https://test.xibo.org.uk/authorize?access_token=<<access_token>>
```



### PHP Library

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





## Resource Server

All further API calls are secured behind the resource server via the URL:

```
https://xibo.org.uk/api
```

The above URL is known as the "home" location and will output the following in a successful request:

```
{
  "title": "Xibo Platform API"
}
```

All responses will have a HTTP status of either 200 or 400/500 (success or failure), with the same code embedded in the JSON response. Errors will have an additional "message" parameter providing a human readable error message.