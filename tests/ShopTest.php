<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2015 Xibo Signage Ltd
 */
namespace XiboTests;

class ShopTest extends TestCase
{
    /**
     * Test creating an android quotation
     * @return int
     * @throws \Exception
     */
    public function testCheckOutAndroid()
    {
        $android = new \Xibo\Platform\Entity\Product\Android();
        $android->emailAddress = 'test@springsignage.com';
        $android->numLicences = 2;

        $cart = new \Xibo\Platform\Entity\Cart($this->getProvider());
        $cart->addProduct($android);

        $order = $cart->checkOut();

        $this->assertNotEmpty($order->orderId);
        $this->assertGreaterThan(0, $order->total);

        return $order->orderId;
    }

    /**
     * Test converting that quotation into an order
     * @depends testCheckOutAndroid
     * @param int $orderId
     * @throws \Xibo\Platform\Api\Error\InvalidArgumentException
     * @throws \Xibo\Platform\Api\Error\NotFoundException
     */
    public function testProcessAndroidQuoteNoAutoPay($orderId)
    {
        $order = new \Xibo\Platform\Entity\Order($this->getProvider());
        $order->getById($orderId);

        $order->complete(false);
    }

    /**
     * Test creating a CMS demo
     * @return int
     * @throws \Exception
     */
    public function testCheckOutCms()
    {
        $cms = new \Xibo\Platform\Entity\Product\Cms();
        $cms->setNewInstance('api' . $this->generateRandomString(5), 2, true, 1);

        $cart = new \Xibo\Platform\Entity\Cart($this->getProvider());
        $cart->addProduct($cms);

        $order = $cart->checkOut();

        $this->assertNotEmpty($order->orderId);

        return $order->orderId;
    }

    /**
     * Test creating a CMS demo and then creating a quotation to convert it to a full account
     * @throws \Exception
     */
    public function testCheckOutCmsDemoThenUpgrade()
    {
        $instanceName = 'api' . $this->generateRandomString(5);
        $cms = new \Xibo\Platform\Entity\Product\Cms();
        $cms->setNewInstance($instanceName, 2, true, 1);

        $cart = new \Xibo\Platform\Entity\Cart($this->getProvider());
        $cart->addProduct($cms);

        $order = $cart->checkOut();
        $order->complete(true);

        // Demo only orders are automatically created.
        $cloud = new \Xibo\Platform\Entity\Cloud($this->getProvider());
        $instance = $cloud->getInstances($instanceName);

        $this->assertNotEmpty($instance);
        $this->assertArrayHasKey('hostingId', $instance);

        // Create another order, to upgrade that instance to a full account
        $cms = new \Xibo\Platform\Entity\Product\Cms();
        $cms->setChangeExistingInstance($instance['hostingId'], 2);

        $cart = new \Xibo\Platform\Entity\Cart($this->getProvider());
        $cart->addProduct($cms);

        $cart->checkOut();
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