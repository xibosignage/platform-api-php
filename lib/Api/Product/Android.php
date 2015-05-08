<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (Android.php)
 */


namespace SpringSignage\Api\Product;


class Android implements Product
{
    public $productId = 1;
    public $emailAddress;
    public $version;
    public $numLicences;

    public function productDetails()
    {
        return [
            'emailAddress' => $this->emailAddress,
            'version' => $this->version,
            'numLicences' => $this->numLicences
        ];
    }
}