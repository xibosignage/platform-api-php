<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (Product.php)
 */


namespace SpringSignage\Api\Product;


interface Product
{
    /**
     * Details for this product
     * @return array
     */
    public function productDetails();
}