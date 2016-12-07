<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */

namespace Xibo\Platform\Entity;

class Shop
{
    /**
     * @return array an array of products
     */
    public static function priceList()
    {
        return self::request('/shop/list')->get([]);
    }

    /**
     * Check out with a set of line items
     * @param array[mixed] $lineItems
     * @return object|string
     */
    public static function checkOut($lineItems)
    {
        if (count($lineItems) <= 0)
            throw new \InvalidArgumentException('Please provide at least one line item');

        // Process the line items and get them in the right order
        $items = [];

        foreach ($lineItems as $item) {

            // We want an object, with a productId and an array of product details
            $object = new \stdClass();
            $object->productId = $item->productId;
            $object->productDetails = $item->productDetails();
            $items[] = $object;
        }

        $curl = self::request('/shop/checkout');
        $response = $curl->post(['lineItems' => json_encode($items)]);

        return $response;
    }

    /**
     * Process a Quotation by OrderId
     * @param int $orderId
     * @param bool[Optional] $autoPay whether or not to auto pay this order, default = true
     * @return string
     */
    public static function processQuote($orderId, $autoPay = true)
    {
        if ($orderId == null || !is_numeric($orderId))
            throw new \InvalidArgumentException('Please provide a valid orderId');

        $autoPay = ($autoPay) ? 1 : 0;

        return self::request('/shop/processquote/' . $orderId)->post(['autoPay' => $autoPay]);
    }
}