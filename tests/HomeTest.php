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
            'baseUrl' => 'https://springsignage.com/portal-test',
            'notificationBaseUrl' => 'https://springsignage.com/portal-test',
            'route' => null,
            'production' => false,
            'data' => [
                'title' => 'Xibo Cloud Platform API'
            ],
            'success' => true,
            'status' => 200,
        ], $this->getProvider()->get('/', ['envelope' => 1]));
    }
}