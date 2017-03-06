<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2017 Spring Signage Ltd
 * (AndroidUpgrade.php)
 */


namespace Xibo\Platform\Entity\Product;


class AndroidUpgrade implements Product
{
    public $androidId;
    public $numberLicences;

    public function productId()
    {
        return 13;
    }

    public function productDetails()
    {
        return [
            'upgradeId' => $this->androidId,
            'numLicences' => $this->numberLicences
        ];
    }
}