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
        $themes = (new \Xibo\Platform\Entity\Cloud($this->getProvider()))->getThemes();
        $this->assertGreaterThanOrEqual(2, count($themes));
    }

    public function testDomainList()
    {
        $domains = (new \Xibo\Platform\Entity\Cloud($this->getProvider()))->getDomains();
        $this->assertGreaterThanOrEqual(3, count($domains));
    }

    public function testInstanceList()
    {
        $instances = (new \Xibo\Platform\Entity\Cloud($this->getProvider()))->getInstances();
        $this->assertGreaterThanOrEqual(1, count($instances));
    }
}