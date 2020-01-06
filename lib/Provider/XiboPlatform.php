<?php

/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2016 Xibo Signage Ltd
 * (XiboPlatform.php)
 */

namespace Xibo\Platform\Provider;

use GuzzleHttp\Psr7\MultipartStream;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Xibo\Platform\Entity\Account;
use Xibo\Platform\Api\Error\ApiException;

class XiboPlatform extends AbstractProvider
{
    use BearerAuthorizationTrait;

    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'id';

    /** @var mixed|string  */
    protected $mode = 'TEST';

    /** @var string|null */
    protected $urlOverride = null;

    /** @var  LoggerInterface */
    protected $logger;

    /** @var AccessToken */
    protected $token;

    /**
     * XiboPlatform constructor.
     * @param array $options
     * @param array $collaborators
     */
    public function __construct(array $options, array $collaborators = [])
    {
        // Pull the mode out of settings.
        if (isset($options['MODE'])) {
            $this->mode = $options['MODE'];
        }

        if (isset($options['urlOverride'])) {
            $this->urlOverride = $options['urlOverride'];
        }

        // Logger
        if (isset($collaborators['logger'])) {
            $this->logger = $collaborators['logger'];
        } else {
            $this->logger = new NullLogger();
        }

        // Parent
        parent::__construct($options, $collaborators);

        $this->getLogger()->debug('Constructed new Xibo Provider');
    }

    /**
     * Get Logger
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Get the Base URL
     * @return string
     */
    private function getBaseUrl()
    {
        return ($this->mode == 'PRODUCTION') ?
            'https://xibo.org.uk' :
            (!empty($this->urlOverride) ? $this->urlOverride : 'https://test.xibo.org.uk');
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
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->getBaseUrl() . '/api/user/account';
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
        $this->logger->debug('Creating resource owner from ' . var_export($response, true));
        return new Account($response);
    }

    /**
     * @return array
     */
    public function getDefaultScopes()
    {
        return [];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        $this->logger->debug('Status Code: ' . $response->getStatusCode());

        // Check HTTP status
        if ($response->getStatusCode() != 200 && $response->getStatusCode() != 201 && $response->getStatusCode() != 204) {
            $this->logger->error('Error: ' . $response->getBody());

            throw (new ApiException())->createFromResponse($response);
        }

        if (!empty($data['error'])) {
            $message = $data['error']['type'].': '.$data['error']['message'];
            throw new IdentityProviderException($message, $data['error']['code'], $data);
        }
    }

    /**
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function me()
    {
        $this->logger->debug('Calling me');

        if ($this->token === null || $this->token->hasExpired()) {
            $this->logger->debug('Get new access token');
            $this->token = $this->getAccessToken('client_credentials');
        }

        return $this->getResourceOwner($this->token);
    }

    /**
     * @param $url
     * @param $params
     * @return mixed|array
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function get($url, $params = [])
    {
        return $this->request('GET', $url . '?' . http_build_query($params));
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function post($url, $params = [])
    {
        return $this->request('POST', $url, $params);
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function put($url, $params = [])
    {
        return $this->request('PUT', $url, $params);
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
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
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    private function request($method, $url, $params = [])
    {
        $this->getLogger()->debug('Request to ' . $method . ' - ' . $url);

        if ($this->token === null || $this->token->hasExpired()) {
            $this->getLogger()->debug('Requesting new access token');
            $this->token = $this->getAccessToken('client_credentials');
        }

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
        } else if ($method == 'POST' || $method == 'PUT' || $method == 'DELETE') {
            $options['headers'] = ['content-type' => 'application/x-www-form-urlencoded'];
            if (count($params) > 0) {
                $options['body'] = http_build_query($params, null, '&');
            }
        }

        $request = $this->getAuthenticatedRequest($method, $this->getBaseUrl() . '/api/' . trim($url, '/'), $this->token, $options);
        $response = $this->getParsedResponse($request);

        $this->getLogger()->debug('Response is: ' . json_encode($response));

        return $response;
    }
}