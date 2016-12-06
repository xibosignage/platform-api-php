<?php

/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (XiboPlatform.php)
 */

namespace Xibo\Platform\Provider;

use Entity\Account;
use GuzzleHttp\Psr7\MultipartStream;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Xibo\Platform\Api\Error\ApiException;

class XiboPlatform extends AbstractProvider
{
    protected $mode = 'TEST';

    /**
     * @var AccessToken
     */
    protected $token;

    public function __construct(array $options, array $collaborators = [])
    {
        // Pull the mode out of settings.
        if (isset($options['MODE']))
            $this->mode = $options['MODE'];

        parent::__construct($options, $collaborators);
    }

    /**
     * Get the Base URL
     * @return string
     */
    private function getBaseUrl()
    {
        return 'http://192.168.1.113/portal';
        //return ($this->mode == 'PRODUCTION') ? 'https://springsignage.com/portal' : 'https://springsignage.com/portal-test';
    }

    /**
     * Get the URL that this provider uses to begin authorization.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->getBaseUrl() . '/authorize';
    }

    /**
     * Get the URL that this provider uses to request an access token.
     *
     * @param $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->getBaseUrl() . '/authorize/access_token';
    }

    /**
     * Get the URL that this provider uses to request user details.
     *
     * Since this URL is typically an authorized route, most providers will require you to pass the access_token as
     * a parameter to the request. For example, the google url is:
     *
     * 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$token
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->getBaseUrl() . '/api/user/me?access_token=' . $token;
    }

    /**
     * Given an object response from the server, process the user details into a format expected by the user
     * of the client.
     *
     * @param array $response
     * @param AccessToken $token
     * @return Account
     */
    public function createResourceOwner(array $response, AccessToken $token)
    {
        return new Account($response);
    }

    public function getDefaultScopes()
    {
        return [];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        // Check HTTP status
        if ($response->getStatusCode() != 200 && $response->getStatusCode() != 201 && $response->getStatusCode() != 204)
            throw new ApiException('Error with response. ' . $response->getStatusCode() . ' - ' . $response->getBody());

        if (!empty($data['error'])) {
            $message = $data['error']['type'].': '.$data['error']['message'];
            throw new IdentityProviderException($message, $data['error']['code'], $data);
        }
    }

    protected function getAuthorizationHeaders($token = null)
    {
        $token = ($token instanceof AccessToken) ? $token->getToken() : $token;

        return ['Authorization' => 'Bearer ' . $token];
    }

    /**
     * @param $url
     * @param $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($url, $params = [])
    {
        return $this->request('GET', $url . '?' . http_build_query($params));
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     */
    public function post($url, $params = [])
    {
        return $this->request('POST', $url, $params);
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     */
    public function put($url, $params = [])
    {
        return $this->request('PUT', $url, $params);
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     */
    public function delete($url, $params = [])
    {
        return $this->request('DELETE', $url, $params);
    }

    /**
     * Request
     * @param $method
     * @param $url
     * @param array $params
     * @return mixed
     */
    private function request($method, $url, $params = [])
    {
        if ($this->token === null || $this->token->hasExpired())
            $this->token = $this->getAccessToken('client_credentials');

        $options = [
            'header', 'body'
        ];

        // Multipart
        if (array_key_exists('multipart', $params)) {
            // Build the multipart message
            $options['body'] = new MultipartStream($params['multipart']);
        } else if (array_key_exists('json', $params)) {
            // Build the JSON body and content type
            $options['body'] = json_encode($params['json']);
            $options['headers'] = ['content-type' => 'application/json'];
        } else if (count($params) > 0) {
            $options['body'] = http_build_query($params, null, '&');
        }

        if ($method == 'PUT' || $method == 'DELETE')
            $options['headers'] =  ['content-type' => 'application/x-www-form-urlencoded'];

        return $this->getResponse($this->getAuthenticatedRequest($method, $this->getBaseUrl() . '/api/' . trim($url, '/'), $this->token, $options));
    }
}