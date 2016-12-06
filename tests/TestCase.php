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
            'clientId' => 'ObGhIB6AuhbdgIW4hd1dczJLHrmE5EJtx4vvhSIf',
            'clientSecret' => '35ac1937ab859b8f5f81d72c8814577037672aa83134d4712c79fd05090ab057',
            'mode' => 'TEST'
        ]);
    }
}