Integration with our platform often centres around offering our services on your own eCommerce platform and automatically posting purchases for approval and completion. This is referred to as placing an order through the API.

When placing an order through the API a simple 3 step process is used.

 - Get the productId for the item your customer is purchasing from your unique price list (you may choose to store this information in your own system) or use one of the products in the PHP library.
 - Create an order for one or more productIds
 - Accept the Order with a saved card or accept and request an invoice (for some items we will insist on a saved card, e.g. a monthly billing CMS instance).

These 3 steps are taken with 3 calls to the API, each listed below in order.



We recommend using the PHP library to simplify these API calls - see [Checking out with PHP](checkout_with_php.md).



## Price List

Get a list of products/services available to purchase and their prices.


    GET https://xibo.org.uk/api/products

  

Returns an array of products with your unique pricing and terms.
     
```json
{
    "products": [
        {
            "productId": "<product id>",
            "name": "<product name>",
            "description": "<product description>",
            "unitCost": "<unit cost - gbp>",
            "terms": "<terms and conditions>",
            "deliveryTerms": "<delivery terms>",
            "unitCostNotes": "<unit cost notes>"
        }
    ]
}
```



Checkout
--------

Post an order request which will be saved as a quotation.


    POST https://xibo.org.uk/api/shop/checkout
     
    {
        "lineItems": [{
            "productId": 2,
            "productDetails": {
                "emailAddress": "<licence pool email address>",
                "version": "1.7",
                "numLicences": 2
            },
            "companyId": <optional child companyId>
        }]
    }

  

Returns an `orderId` and costing (see order structure below).




Process Quote
-------------

Post a quote accept message and either invoice or auto-charge using a saved card.


    POST http://xibo.org.uk/api/shop/processquote/<orderId>
     
    {
       "autoPay": <0 or 1>
    }

  

Returns and order (see order structure below)


    {
      order: {}
    }

 

 

My Account
----------

It is possible to view your current account position (your account details), including any customers you have registered with us.


    GET https://xibo.org.uk/api/user/account

Returns

```json
{
    "user": {
        "id": "9",
        "userName": "<your user name>",
        "dateCreated": "<account created date>",
        "lastLogin": "<last login>",
        "blockExpires": "<if blocked, when does the block expire",
        "companyId": "<home companyId>",
        "rfStatusId": "<account status>",
        "emailMarketing": "<whether email marketing is enabled>",
        "rfStatus": "<account status>",
        "clientId": "<api client key>",
        "clientName": "<api client name>"
    }
}
```



Or with PHP

```php
$provider->me();
```



  


Orders
------

Should you wish to list out your recent orders, you may do so:


    GET http://xibo.org.uk/user/orders

Returns

```json
{
    [
        {
            "billingEmail": "<order billing email>",
            "companyId": "<order companyId>",
            "orderId": "<order number>",
            "orderDate": "<order date>",
            "paymentType": "<payment type>",
            "paymentTerms": "<payment terms, days>",
            "rfStatusId": "<order status>",
            "subTotal": "<sub total>",
            "discount": "<discount>",
            "vat": "<vat>",
            "total": "<total>",
            "currency": "<currency>",
            "paymentLink": "<order payment code>",
            "purchaseOrderNumber": <purchase order number, if applicable>,
            "rfStatus": "<order status>",
            "billingName": "<billing name>",
            "company": "<billing company>"
        }
    ]
}
```
