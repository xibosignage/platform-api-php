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
    public function testProcessAndroidQuoteNoAutoPay($orderId)
    {
        self::setFromEnv();

        SpringSignage\Api\Shop::processQuote($orderId, false);
    }

    public function testCheckOutCms()
    {
        self::setFromEnv();

        $cms = new \SpringSignage\Api\Product\CloudCms();
        $cms->setNewInstance('api' . $this->generateRandomString(5), 2, true, \SpringSignage\Api\Cloud::$LONDON);

        $order = \SpringSignage\Api\Shop::checkOut([$cms]);

        $this->assertNotEmpty($order);

        $this->assertArrayHasKey('orderId', (array)$order);

        return $order->orderId;
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}