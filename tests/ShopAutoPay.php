<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (ShopAutoPay.php)
 */


class ShopAutoPay extends TestCase
{
    /**
     * Test creating an android quotation
     * @return int
     * @throws Exception
     */
    public function testCheckOutAndroidAutoPay()
    {
        $android = new \Xibo\Platform\Entity\Product\Android();
        $android->emailAddress = 'test@springsignage.com';
        $android->version = '1.7';
        $android->numLicences = 2;

        $cart = new \Xibo\Platform\Entity\Cart($this->getProvider());
        $cart->addProduct($android);
        $order = $cart->checkOut();

        $this->assertNotEmpty($order);

        $this->assertObjectHasAttribute('orderId', $order);

        return $order->orderId;
    }

    /**
     * Test converting that quotation into an order
     * @param int $orderId
     * @depends testCheckOutAndroidAutoPay
     */
    public function testProcessAndroidQuoteAutoPay($orderId)
    {
        $order = new \Xibo\Platform\Entity\Order($this->getProvider());
        $order->getById($orderId);

        $order->complete(1);
    }
}