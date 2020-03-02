# Xibo for Android

You can list out Xibo for Android licence pools and licenses using the API. Usually this is done to show your customers their purchased licences and allow them to perform simple account management tasks. You should always ensure that you use the `apiRef` provided when your customer purchased the licences so that you do not show different customers each others data.

The API will allow operations to be performed on all Android Licence Pools that your account has permissions to view/edit/delete and it is your responsibiliy to ensure you only show the correct items to the correct customers.

There are 3 operations:

- View Licence Pools
- View Licence Entries
- Delete Licence Entries



## View Licence Pools

Make a GET request to `/android` to see all your android licence pools.

```bash
curl --location --request GET 'https://test.xibo.org.uk/api/android' \
--header 'Authorization: Bearer access_token'
```

Returns an array of Android Licence Pools with Version information (one per version)

```json
[
    {
        "uid": "1362_1720",
        "companyId": 3650,
        "androidId": 1362,
        "versionId": 1720,
        "email": "email@example.com",
        "version": "2",
        "numberOfLicences": 6,
        "numberOfUpgrades": 0,
        "onPremise": 0,
        "renewalDate": 0,
        "isRenew": 0,
        "isMonthly": 0,
        "numberOfPlayers": 0,
        "numberOfRenewals": 0,
        "lastPing": null,
        "company": "Test Company",
        "upgradesAvailable": true
    }
]
```

You can filter the response using query params:

- `includeChildCompanies`: show only your own pools (0) or pools from your child companies (1)
- `companyApiRef`: when `includeChildCompanies=1` filter by the company API reference used to purchase the licences.



Or using PHP

```php
$android = (new Android($provider));

// To get all pools
$pools = $android->getPools();

// To get by VersionId
$pools = $android->getByVersionId(1);
```



## View Licence Entries

To get a list of devices linked to a Pool and Version you use the following GET request with the Version Id substituted:

```bash
curl --location --request GET 'https://test.xibo.org.uk/api/android/devices/{versionId}' \
--header 'Authorization: Bearer access_token'
```

Returns an array of devices:

```json
[
    {
        "licenceId": 1,
        "uid": "00:00:00:00:00:00",
        "pingDate": "2020-03-02 13:03:47",
        "blocked": 0,
        "versionCode": 204,
        "versionId": 13472,
        "name": "Name",
        "model": "DSCS9",
        "manufacturer": "DSDevices",
        "version": "2",
        "isRental": 0
    }
]
```



Or with PHP

```php
$provider->get('/android/devices/' . $versionId);
```



## Delete Licence Entries

To delete a licence entry you make a DELETE request:

```bash
curl --location --request DELETE 'https://test.xibo.org.uk/api/android/devices/{versionId}/{licenceId}' \
--header 'Authorization: Bearer access_token'
```

Or with PHP

```php
// To delete
$provider->delete('/android/devices/' . $versionId . '/' . $licenceId);
```

