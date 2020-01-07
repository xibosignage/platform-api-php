Integration with our platform often centres around offering our services on your own eCommerce platform and automatically posting purchases for approval and completion. This is referred to as placing an order through the API.

When placing an order through the API a simple 3 step process is used.

 - Get the productId for the item your customer is purchasing from your unique price list (you may choose to store this information in your own system) or use one of the products in the PHP library.
 - Create an order for one or more productIds
 - Accept the Order with a saved card or accept and request an invoice (for some items we will insist on a saved card, e.g. a monthly billing CMS instance).

These 3 steps are taken with 3 calls to the API, each listed below in order.



We recommend using the PHP library to simplify these API calls - see [Checking out with PHP](checkout_with_php.md). Following are examples using curl should you not wish to use PHP.



## Price List

Get a list of products/services available to purchase and their prices.


```bash
curl -X GET \
  https://test.xibo.org.uk/api/products \
  -H 'Accept: */*' \
  -H 'Accept-Encoding: gzip, deflate' \
  -H 'Authorization: Bearer access_token' \
  -H 'Cache-Control: no-cache' \
  -H 'Connection: keep-alive' \
  -H 'Host: test.xibo.org.uk' \
  -H 'cache-control: no-cache'
```


Returns an array of products with your unique pricing and terms.
```json
{
    "products": [
        {
            "productId": "<product id>",
            "name": "<product name>",
            "description": "<product description>",
            "costs": [
               {
                   "unitCost": 0,
                   "unitCostNotes": "Notes",
                   "currencySymbol": "$|£|€"
               } 
            ],
            "terms": "<terms and conditions>",
            "deliveryTerms": "<delivery terms>"
        }
    ]
}
```



All `GET` requests which return arrays of data come in pages. You can use the `X-Total-Count` header to see how many records there are in total.

You can use the `start` and `length` parameters to request additional pages.



Validate Cart and Checkout
--------

To validate/checkout a cart you need to have some line items. Each line item has a `productId` and some `productDetails`. The details required depend on the product you're ordering.

For Android the details are:

- `emailAddress`
- `version`
- `numLicences`



For New Cloud the details are:

- `account_name`
- `displays`
- `monthly_billing`
- `is_demo`
- `region_id`
- `domain_id`
- `theme_id`
- `cms_version_id`



For example Cloud the details are:

- `displays`
- `upgradeId`



If you would like to validate your cart before you checkout, you can do so using the validate route.

```bash
curl -X POST \
  https://test.xibo.org.uk/api/user/cart/validate \
  -H 'Accept: */*' \
  -H 'Accept-Encoding: gzip, deflate' \
  -H 'Authorization: Bearer access_code' \
  -H 'Cache-Control: no-cache' \
  -H 'Connection: keep-alive' \
  -H 'Content-Length: 265' \
  -H 'Content-Type: application/json' \
  -H 'Host: test.xibo.org.uk' \
  -H 'cache-control: no-cache' \
  -d '{
    "lineItems": [
        {
            "productId": 1,
            "productDetails": {
                "emailAddress": "dan@xibosignage.com",
                "version": "1.7",
                "numLicences": 2
            }
        }
    ]
}'
```

Make sure you provide the Content-Type and Content-Length headers correctly.

If this request returns a 200, the body will contain an Order entity without an `orderId`.



If you are happy you can then checkout the order, which will save it as a quotation and provide an `orderId` in the response.


    curl -X POST \
      https://test.xibo.org.uk/api/user/checkout \
      -H 'Accept: */*' \
      -H 'Accept-Encoding: gzip, deflate' \
      -H 'Authorization: Bearer access_code' \
      -H 'Cache-Control: no-cache' \
      -H 'Connection: keep-alive' \
      -H 'Content-Length: 265' \
      -H 'Content-Type: application/json' \
      -H 'Host: test.xibo.org.uk' \
      -H 'cache-control: no-cache' \
      -d '{
        "lineItems": [
            {
                "productId": 1,
                "productDetails": {
                    "emailAddress": "dan@xibosignage.com",
                    "version": "1.7",
                    "numLicences": 2
                }
            }
        ]
    }'

  


Returns an `orderId` and costing (see order structure below).




Process Quote
-------------

Post a quote accept message and either invoice (`autoPay=0`) or auto-charge using a saved card (`autoPay=1`).


    curl -X POST \
      https://test.xibo.org.uk/api/shop/processquote/1234555 \
      -H 'Accept: */*' \
      -H 'Accept-Encoding: gzip, deflate' \
      -H 'Authorization: Bearer access_token' \
      -H 'Cache-Control: no-cache' \
      -H 'Connection: keep-alive' \
      -H 'Content-Length: 163' \
      -H 'Content-Type: application/x-www-form-urlencoded' \
      -H 'Host: test.xibo.org.uk' \
      -H 'cache-control: no-cache' \
      -d autoPay=0


Returns and order (see order structure below)


    {
      order: {}
    }






Orders
------

Should you wish to list out your recent orders, you may do so:


```bash
curl -X GET \
  https://test.xibo.org.uk/api/user/orders \
  -H 'Accept: */*' \
  -H 'Accept-Encoding: gzip, deflate' \
  -H 'Authorization: Bearer access_token' \
  -H 'Cache-Control: no-cache' \
  -H 'Connection: keep-alive' \
  -H 'Host: test.xibo.org.uk' \
  -H 'cache-control: no-cache'
```

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
            "purchaseOrderNumber": "<purchase order number, if applicable>",
            "rfStatus": "<order status>",
            "billingName": "<billing name>",
            "company": "<billing company>"
        }
    ]
}
```
