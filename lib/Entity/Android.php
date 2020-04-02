<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2017 Xibo Signage Ltd
 * (Android.php)
 */


namespace Xibo\Platform\Entity;


use Xibo\Platform\Api\Error\NotFoundException;

class Android extends Base
{
    use EntityTrait;

    /**
     * Get Pools by their Version Id
     * @param $id
     * @return mixed
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     * @throws \Xibo\Platform\Api\Error\NotFoundException
     */
    public function getByVersionId($id)
    {
        $data = $this->getProvider()->get('/android', ['search' => 'versionid|' . $id]);

        if (count($data) < 0)
            throw new NotFoundException('Android Licence Pool ID with VersionId ' . $id . ' ID not found', 'android');

        return $data[0];
    }

    /**
     * Get all Pools for the connected account
     * @param string $emailAddress
     * @param string $version
     * @param null $apiRef
     * @return array|mixed
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     * @throws \Xibo\Platform\Api\Error\NotFoundException
     */
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
            if (count($data) <= 0) {
                throw new NotFoundException('Email Address ' . $emailAddress . ' not found', 'android');
            }

            return $data[0];
        }
    }
}