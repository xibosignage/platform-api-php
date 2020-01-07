<?php

/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2017 Xibo Signage Ltd
 * (AndroidTest.php)
 */
namespace XiboTests;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Xibo\Platform\Api\Error\NotFoundException;

class AndroidTest extends TestCase
{
    public function testGetPools()
    {
        $android = new \Xibo\Platform\Entity\Android($this->getProvider());
        try {
            $pools = $android->getPools();

            $this->assertGreaterThan(0, count($pools));

        } catch (\Exception $e) {
            $this->throwException($e);
        }
    }
}