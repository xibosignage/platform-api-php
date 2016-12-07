<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */

namespace Xibo\Platform\Entity;

use Api\Error\InvalidArgumentException;
use Xibo\Platform\Entity\Product\Product;

class Shop extends Base
{
    use EntityTrait;

    /** @var Product[] */
    private $lineItems = [];

    /**
     * Add a line item
     * @param Product $item
     */
    public function addLineItem($item)
    {
        $this->lineItems[] = $item;
    }

    /**
     * Check out with a set of line items
     * @return Order
     * @throws InvalidArgumentException
     */
    public function checkOut()
    {
        if (count($this->lineItems) <= 0)
            throw new InvalidArgumentException('Please provide at least one line item');

        // Process the line items and get them in the right order
        $items = [];

        foreach ($this->lineItems as $item) {
            // We want an object, with a productId and an array of product details
            $object = new \stdClass();
            $object->productId = $item->productId();
            $object->productDetails = $item->productDetails();
            $items[] = $object;
        }

        $order = $this->getProvider()->post('/user/checkout', ['lineItems' => json_encode($items)]);

        return (new Order($this->getProvider()))->hydrate($order);
    }
}