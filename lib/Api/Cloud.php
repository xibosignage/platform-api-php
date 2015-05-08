<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (Cloud.php)
 */


namespace SpringSignage\Api;


class Cloud extends Api
{
    public static $LONDON = 1;
    public static $NEWYORK = 2;
    public static $SINGAPORE = 3;

    public function getThemes()
    {
        return self::request('/theme')->get([]);
    }

    public function getDomains()
    {
        return self::request('/cloud/domain')->get([]);
    }
}