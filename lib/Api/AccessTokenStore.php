<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */


namespace SpringSignage\Api;


interface AccessTokenStore
{
    /**
     * Save the Provided Access Token
     * @param AccessToken $token
     */
    public function save(AccessToken $token);

    /**
     * Load the Stored Access Token
     * @return AccessToken
     */
    public function load();
}