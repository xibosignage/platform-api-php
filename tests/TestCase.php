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

        self::assertNotFalse($clientId);
        self::assertNotFalse($clientSecret);

        \SpringSignage\Api\Api::setClientCredentials('test', $clientId, $clientSecret, new FileAccessTokenStore());
    }
}