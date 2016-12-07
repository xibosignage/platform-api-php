<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */


class TestCase extends PHPUnit_Framework_TestCase
{
    protected $provider;

    protected function setUp()
    {
        // Connect to the API
        $clientId = getenv('clientId');
        $clientSecret = getenv('clientSecret');

        if (!$clientId || !$clientSecret)
            throw new Exception('Environment not configured for testing');

        $this->provider = new \Xibo\Platform\Provider\XiboPlatform([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'mode' => 'TEST'
        ]);
    }
}