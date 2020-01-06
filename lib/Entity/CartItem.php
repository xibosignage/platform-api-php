<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2016 Xibo Signage Ltd
 * (ShopItem.php)
 */


namespace Xibo\Platform\Entity;


use Xibo\Platform\Entity\Product\Product;

class CartItem implements \JsonSerializable
{
    private $companyId;
    private $customerName;
    private $apiRef;

    /** @var  Product */
    private $product;

    /**
     * Create Item for own company
     * @param Product $product the product to purchase
     * @param int|null $companyId if the item is for a specific company and that platform companyId is known
     * @return $this
     */
    public function createItem($product, $companyId = null)
    {
        $this->product = $product;
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Create Shop Item for Customer
     * @param Product $product the product to purchase
     * @param string $apiRef the uniqueId of this customer in the 3rd party system
     * @param string $customerName the customer name
     * @return $this
     */
    public function createItemForCustomer($product, $apiRef, $customerName)
    {
        $this->product = $product;
        $this->apiRef = $apiRef;
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Json Serialize
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'companyId' => $this->companyId,
            'customerName' => $this->customerName,
            'apiRef' => $this->apiRef,
            'productId' => $this->product->productId(),
            'productDetails' => $this->product->productDetails()
        ];
    }
}