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

    public static function getThemes()
    {
        return self::request('/theme')->get([]);
    }

    public static function getDomains()
    {
        return self::request('/cloud/domain')->get([]);
    }

    /**
     * Get CMS Instances
     * @param string[Optional] $name
     * @return string
     */
    public static function getInstances($name = '')
    {
        $params = [];

        if ($name != '') {
            $params['search'] = 'accountName|' . $name;
        }

        $data = self::request('/cloud')->get($params);

        return ($name == '') ? $data : $data->data[0];
    }
}