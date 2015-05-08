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
        self::setFromEnv();

        $android = new \SpringSignage\Api\Product\Android();
        $android->emailAddress = 'test@springsignage.com';
        $android->version = '1.7';
        $android->numLicences = 2;

        $order = \SpringSignage\Api\Shop::checkOut([$android]);

        $this->assertNotEmpty($order);

        $this->assertArrayHasKey('orderId', (array)$order);

        return $order->orderId;
    }

    /**
     * Test converting that quotation into an order
     * @depends testCheckOutAndroidAutoPay
     */
    public function testProcessAndroidQuoteAutoPay($orderId)
    {
        self::setFromEnv();

        SpringSignage\Api\Shop::processQuote($orderId, true);
    }
}