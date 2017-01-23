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
     * Get instance by Id
     * @param $id
     * @return array
     * @throws NotFoundException
     */
    public function getById($id)
    {
        $data = $this->getProvider()->get('/cloud', ['hostingId' => $id]);

        if (count($data) < 0)
            throw new NotFoundException('Instance ' . $id . ' ID not found', 'cloud');

        return $data[0];
    }

    /**
     * Get CMS Instances
     * @param string[Optional] $name
     * @param string[Optional] $apiRef the api reference for the customer purchasing the CMS instance
     * @return array
     * @throws NotFoundException
     */
    public function getInstances($name = '', $apiRef = null)
    {
        $params = [];

        if ($name != '') {
            $params['search'] = 'accountName|' . $name;
        }

        if ($apiRef !== null) {
            $params['companyApiRef'] = $apiRef;
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