<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */

namespace Xibo\Platform\Entity;

use Xibo\Platform\Api\Error\InvalidArgumentException;
use Xibo\Platform\Entity\Product\Product;

class Cart extends Base
{
    use EntityTrait;

    /** @var CartItem[] */
    private $lineItems = [];

    /**
     * Add a line item to the card
     * @param CartItem $item
     */
    public function addLineItem($item)
    {
        $this->lineItems[] = $item;
    }

    /**
     * Add a product to the cart
     * @param Product $product
     */
    public function addProduct($product)
    {
        $this->lineItems[] = (new CartItem())->createItem($product);
    }

    /**
     * Validate the cart
     * @return Order
     * @throws InvalidArgumentException
     */
    public function validate()
    {
        if (count($this->lineItems) <= 0)
            throw new InvalidArgumentException('Please provide at least one line item');

        $lineItems = json_encode($this->lineItems);

        $this->getProvider()->getLogger()->debug('Checkout with line items: ' . $lineItems);

        return (new Order($this->getProvider()))->hydrate($this->getProvider()->post('/user/cart/validate', ['lineItems' => $lineItems]));
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

        $lineItems = json_encode($this->lineItems);

        $this->getProvider()->getLogger()->debug('Checkout with line items: ' . $lineItems);

        return (new Order($this->getProvider()))->hydrate($this->getProvider()->post('/user/checkout', ['lineItems' => $lineItems]));
    }
}