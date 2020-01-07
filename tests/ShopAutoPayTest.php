<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2015 Xibo Signage Ltd
 * (ShopAutoPay.php)
 */
namespace XiboTests;

class ShopAutoPayTest extends TestCase
{
    /**
     * Test creating an android quotation
     * @return int
     * @throws \Exception
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
     * @throws \Xibo\Platform\Api\Error\InvalidArgumentException
     * @throws \Xibo\Platform\Api\Error\NotFoundException
     * @depends testCheckOutAndroidAutoPay
     */
    public function testProcessAndroidQuoteAutoPay($orderId)
    {
        $order = new \Xibo\Platform\Entity\Order($this->getProvider());
        $order->getById($orderId);

        $order->complete(1);
    }
}