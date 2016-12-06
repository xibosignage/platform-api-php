<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */


class HomeTest extends TestCase
{
    public function testHome()
    {
        $this->assertSame([
            "title" => "Spring Signage Customer Portal API",
            "error" => false,
            "status" => 200
        ], (array)\SpringSignage\Api\Api::home());
    }
}