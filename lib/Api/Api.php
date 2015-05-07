<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 */


namespace SpringSignage\Api;


use SpringSignage\Api\Error\ApiException;
use Curl\Curl;

class Api
{
    public static $productionUrl = 'https://springsignage.com/portal/';
    public static $testUrl = 'https://springsignage.com/portal-test/';
    private static $clientId;
    private static $clientSecret;
    private static $url;

    /**
     * @var AccessTokenStore access token store
     */
    protected static $accessTokenStore;

    private static function getAuthorizeUrl()
    {
        return self::$url . 'authorize';
    }

    private static function getResourceUrl()
    {
        return self::$url . 'api';
    }

    /**
     * Set the client credentials for your application
     * @param string $mode either production or test
     * @param string $clientId the client Id
     * @param string $clientSecret the client Secret
     * @param AccessTokenStore $accessTokenStore the access token store to use
     */
    public static function setClientCredentials($mode, $clientId, $clientSecret, $accessTokenStore)
    {
        self::$url = ($mode == 'production') ? self::$productionUrl : self::$testUrl;
        self::$clientId = $clientId;
        self::$clientSecret = $clientSecret;

        if (!$accessTokenStore instanceof AccessTokenStore)
            throw new \InvalidArgumentException('3rd parameter must be a class that implemented AccessTokenStore');

        self::$accessTokenStore = $accessTokenStore;
    }

    /**
     * Get access token
     * @return AccessToken
     * @throws ApiException
     */
    private static function getAccessToken()
    {
        if (self::$accessTokenStore == null)
            throw new \InvalidArgumentException('Please set your client credentials before making an API call');

        $accessToken = self::$accessTokenStore->load();

        // Try to get an access token out of the store
        if (!$accessToken || $accessToken->timeout < time()) {
            // Call authorization server to get the access token
            $curl = new Curl();
            $curl->post(self::getAuthorizeUrl() . '/access_token', [
                'client_id' => self::$clientId,
                'client_secret' => self::$clientSecret,
                'grant_type' => 'client_credentials'
            ]);

            if ($curl->error) {
                throw new ApiException($curl->error_message);
            }
            else {
                $accessToken = new AccessToken();
                $accessToken->url = self::getResourceUrl();
                $accessToken->token = $curl->response->access_token;
                $accessToken->timeout = $curl->response->expires_in + time();

                self::$accessTokenStore->save($accessToken);
            }

            $curl->close();
        }

        return $accessToken;
    }

    /**
     * Make a request
     * @param string $route the route to call
     * @return Curl
     * @throws ApiException
     */
    protected static function request($route = '')
    {
        $accessToken = self::getAccessToken();
        $curl = new Curl();
        $curl->base_url = $accessToken->url . (($route != '') ? $route : '');
        $curl->setHeader('Authorization', $accessToken->token);
        $curl->complete(function() use ($curl) {
            $curl->close();
        });
        $curl->error(function() use ($curl) {
            $message = (is_object($curl->response)) ? $curl->response->message : $curl->error_message;
            throw new ApiException($message);
        });

        return $curl;
    }

    /**
     * Home
     * @return string
     */
    public static function home()
    {
        $request = self::request();
        return $request->get([]);
    }
}