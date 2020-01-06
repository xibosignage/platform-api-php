# Checkout with PHP

The PHP library makes checkout straightforward.



### Purchase Android Licences

To purchase android licences first create a Cart and check out to get an `orderId`. This creates a quotation.

```php
$android = new \Xibo\Platform\Entity\Product\Android();
$android->emailAddress = 'test@xibosignage.com';
$android->numLicences = 2;

$cart = new \Xibo\Platform\Entity\Cart($this->getProvider());
$cart->addProduct($android);

$order = $cart->checkOut();

echo 'The orderId is' . $order->orderId;

// Store this in your own system
```

Then complete the order:

```php
$order = new \Xibo\Platform\Entity\Order($this->getProvider());
$order->getById($orderId);

$order->complete(false); //false to create an invoice, true to auto-pay using your stored card.
```



### Purchase Cloud CMS instances

Create a CMS and call `setNewInstance` to purchase a new CMS. 

```php
$cms = new \Xibo\Platform\Entity\Product\Cms();
$cms->setNewInstance('api' . $this->generateRandomString(5), 2, true, 1);

$cart = new \Xibo\Platform\Entity\Cart($this->getProvider());
$cart->addProduct($cms);

$order = $cart->checkOut();
```



To get this CMS back again after Payment:

```php
$cloud = new \Xibo\Platform\Entity\Cloud($this->getProvider());
$instance = $cloud->getInstances($instanceName);
```

You can then renew it if needed, or upgrade from a demo to a paid account:

```php
$cms = new \Xibo\Platform\Entity\Product\Cms();
$cms->setChangeExistingInstance($instance['hostingId'], 2);

$cart = new \Xibo\Platform\Entity\Cart($this->getProvider());
$cart->addProduct($cms);

$cart->checkOut();
```



### Completing Orders

Don't forget to complete Orders after you've checked out.



## Creating Customers

The above examples have assumed your account is the owner of each product and that you are providing them as a service to your own customers, as a White Label Reseller or as a Managed Service Provider.

However if you are a distributor you will want to assign these products to your end customer. The process is broadly the same, except you will want to manually create the cart item, with an `apiRef` and `customerName`.

The API ref should be a unique Id for this customer in your own system, so that repeated orders are assigned to the same record.

```php
$cartItem = (new \Xibo\Platform\Entity\CartItem())->createItemForCustomer($android, $apiRef, $customerName);

// Add this item to the Cart
$cart->addLineItem($cartItem);
```



## Order Status

After completing your Order you will either trigger an invoice to be paid manually, or will have auto payed using your saved card.

You may then want to track the status of the Order in your system.

To do this you should supply a web hook URL with the `complete()` call.

```php
$order->complete(true, $url);
```

This URL will be called when the order has completed and the products are ready. We do not add any contents to the POST body of the URL, and you should always check the contents of the message by looking up the details when you process the hook.