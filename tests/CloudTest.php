<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (CloudTest.php)
 */


class CloudTest extends TestCase
{
    public function testThemeList()
    {
        self::setFromEnv();

        $themes = \SpringSignage\Api\Cloud::getThemes();

        $this->assertArrayHasKey('data', (array)$themes);
        $this->assertGreaterThanOrEqual(2, count((array)$themes));
    }

    public function testDomainList()
    {
        self::setFromEnv();

        $domains = \SpringSignage\Api\Cloud::getDomains();

        $this->assertArrayHasKey('data', (array)$domains);
        $this->assertGreaterThanOrEqual(3, count((array)$domains));
    }

    public function testInstanceList()
    {
        self::setFromEnv();

        $instances = \SpringSignage\Api\Cloud::getInstances();

        $this->assertArrayHasKey('data', (array)$instances);
    }
}