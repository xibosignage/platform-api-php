<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */

class ShopTest extends TestCase
{
    /**
     * Test getting a price list
     * @throws Exception
     */
    public function testPriceList()
    {
        self::setFromEnv();

        $products = \SpringSignage\Api\Shop::priceList();

        $this->assertArrayHasKey('products', (array)$products);
    }

    /**
     * Test creating an android quotation
     * @return int
     * @throws Exception
     */
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
     * Test converting that quotation into an order
     * @depends testCheckOutAndroid
     */
    public function testProcessAndroidQuoteNoAutoPay($orderId)
    {
        self::setFromEnv();

        SpringSignage\Api\Shop::processQuote($orderId, false);
    }

    /**
     * Test creating a CMS demo
     * @return int
     * @throws Exception
     */
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
     * Test creating a CMS demo and then creating a quotation to convert it to a full account
     * @throws Exception
     */
    public function testCheckOutCmsDemoThenUpgrade()
    {
        self::setFromEnv();

        $cms = new \SpringSignage\Api\Product\CloudCms();
        $accountName = strtolower('api' . $this->generateRandomString(5));
        $cms->setNewInstance($accountName , 2, true, \SpringSignage\Api\Cloud::$LONDON);

        $order = \SpringSignage\Api\Shop::checkOut([$cms]);

        $this->assertNotEmpty($order);
        $this->assertArrayHasKey('orderId', (array)$order);

        // Process quote
        SpringSignage\Api\Shop::processQuote($order->orderId, false);

        // Demo's are automatically created, so we can get this demo now
        $instance = \SpringSignage\Api\Cloud::getInstances($accountName);

        $this->assertEquals($accountName, $instance->accountName);

        // Create another CMS product
        $cms = new \SpringSignage\Api\Product\CloudCms();
        $cms->setChangeExistingInstance($instance->hostingId, $instance->displays);

        $order = \SpringSignage\Api\Shop::checkOut([$cms]);

        $this->assertNotEmpty($order);
        $this->assertArrayHasKey('orderId', (array)$order);
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