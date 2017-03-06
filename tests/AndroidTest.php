<?php

/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2017 Spring Signage Ltd
 * (AndroidTest.php)
 */


class AndroidTest extends TestCase
{
    public function testGetPools()
    {
        $android = new \Xibo\Platform\Entity\Android($this->getProvider());
        $pools = $android->getPools();

        $this->assertGreaterThan(0, count($pools));
    }
}