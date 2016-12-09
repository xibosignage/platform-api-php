<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (Cloud.php)
 */


namespace Xibo\Platform\Entity;

use Xibo\Platform\Api\Error\NotFoundException;

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
     * @return array
     * @throws NotFoundException
     */
    public function getInstances($name = '')
    {
        $params = [];

        if ($name != '') {
            $params['search'] = 'accountName|' . $name;
        }

        $data = $this->getProvider()->get('/cloud', $params);

        if ($name == '') {
            return $data;
        } else {
            if (count($data) < 0)
                throw new NotFoundException('Instance ' . $name . ' not found', 'cloud');

            return $data[0];
        }
    }
}