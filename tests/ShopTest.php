<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */

class ShopTest extends TestCase
{
    public function testPriceList()
    {
        self::setFromEnv();

        $products = \SpringSignage\Api\Shop::priceList();

        $this->assertArrayHasKey('products', (array)$products);
    }

    public function testCheckOutAndroid()
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
     * @depends testCheckOutAndroid
     */
    public function testProcessQuoteNoAutoPay($orderId)
    {
        self::setFromEnv();

        SpringSignage\Api\Shop::processQuote($orderId, false);
    }
}