<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (Base.php)
 */


namespace Xibo\Platform\Entity;

use Xibo\Platform\Provider\XiboPlatform;

class Base
{
    /**
     * @var XiboPlatform
     */
    private $provider;

    /**
     * Base constructor.
     * @param $provider
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return XiboPlatform
     */
    protected function getProvider()
    {
        return $this->provider;
    }
}