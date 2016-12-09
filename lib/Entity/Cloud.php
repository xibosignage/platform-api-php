<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (Cloud.php)
 */


namespace Xibo\Platform\Entity;

class Cloud extends Base
{
    use EntityTrait;

    /**
     * @return array
     */
    public function getRegions()
    {
        return $this->getProvider()->get('/cloud/region');
    }

    /**
     * Get Themes
     * @return array
     */
    public function getThemes()
    {
        return $this->getProvider()->get('/theme');
    }

    /**
     * Get Domains
     * @return array
     */
    public function getDomains()
    {
        return $this->getProvider()->get('/cloud/domain');
    }

    /**
     * Get CMS Instances
     * @param string[Optional] $name
     * @return string
     */
    public function getInstances($name = '')
    {
        $params = [];

        if ($name != '') {
            $params['search'] = 'accountName|' . $name;
        }

        $data = $this->getProvider()->get('/cloud', $params);

        return ($name == '') ? $data : $data->data[0];
    }
}