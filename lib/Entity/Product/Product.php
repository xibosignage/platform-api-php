<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2015 Xibo Signage Ltd
 * (Product.php)
 */


namespace Xibo\Platform\Entity\Product;


interface Product
{
    /**
     * Product Id
     * @return int
     */
    public function productId();

    /**
     * Details for this product
     * @return array
     */
    public function productDetails();
}