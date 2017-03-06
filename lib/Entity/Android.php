<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2017 Spring Signage Ltd
 * (Android.php)
 */


namespace Xibo\Platform\Entity;


use Xibo\Platform\Api\Error\NotFoundException;

class Android extends Base
{
    use EntityTrait;

    public function getByVersionId($id)
    {
        $data = $this->getProvider()->get('/android', ['search' => 'versionid|' . $id]);

        if (count($data) < 0)
            throw new NotFoundException('Android Licence Pool ID with VersionId ' . $id . ' ID not found', 'android');

        return $data[0];
    }

    public function getPools($emailAddress = '', $version = '', $apiRef = null)
    {
        $params = [];

        if ($emailAddress != '') {
            $params['search'] = 'email|' . $emailAddress;
        }

        if ($version != '') {
            $params['search'] .= ' version|' . $version;
        }

        if ($apiRef !== null) {
            $params['companyApiRef'] = $apiRef;
        }

        $data = $this->getProvider()->get('/android', $params);

        if ($emailAddress == '') {
            return $data;
        } else {
            if (count($data) < 0)
                throw new NotFoundException('Email Address ' . $emailAddress . ' not found', 'android');

            return $data[0];
        }
    }
}