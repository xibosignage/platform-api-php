<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2016 Xibo Signage Ltd
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