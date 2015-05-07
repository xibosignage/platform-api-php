<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */


class FileAccessTokenStore implements \SpringSignage\Api\AccessTokenStore
{
    private $file = 'TOKEN';

    public function load()
    {
        if (!file_exists($this->file))
            return null;

        return unserialize(file_get_contents($this->file));
    }

    /**
     * @param SpringSignage\Api\AccessToken $token
     */
    public function save(SpringSignage\Api\AccessToken $token)
    {
        file_put_contents($this->file, serialize($token));
    }
}