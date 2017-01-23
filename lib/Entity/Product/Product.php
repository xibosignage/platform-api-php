<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
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