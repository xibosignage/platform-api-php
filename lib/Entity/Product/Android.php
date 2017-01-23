<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (Android.php)
 */


namespace Xibo\Platform\Entity\Product;


class Android implements Product
{
    public $emailAddress;
    public $version;
    public $numLicences;

    public function productId()
    {
        return 1;
    }

    public function productDetails()
    {
        return [
            'emailAddress' => $this->emailAddress,
            'version' => $this->version,
            'numLicences' => $this->numLicences
        ];
    }
}