<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */


class TestCase extends PHPUnit_Framework_TestCase
{
    protected static function setFromEnv()
    {
        $clientId = getenv('clientId');
        $clientSecret = getenv('clientSecret');

        if (!$clientId || !$clientSecret)
            throw new Exception('Environment not configured for testing');

        \SpringSignage\Api\Api::setClientCredentials('test', $clientId, $clientSecret, new FileAccessTokenStore());
    }
}