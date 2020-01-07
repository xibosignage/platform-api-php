<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2015 Xibo Signage Ltd
 */


namespace Xibo\Platform\Api\Error;


use Psr\Http\Message\ResponseInterface;

class ApiException extends \Exception
{
    protected $code = 500;

    /**
     * @param ResponseInterface $response
     * @return $this
     */
    public function createFromResponse($response)
    {
        $this->code = $response->getStatusCode();

        if (!$decoded = json_decode($response->getBody())) {
            $this->message = 'Status Code: ' . $response->getStatusCode() . '. JSON Error: ' . json_last_error_msg();
        } else {
            $this->message = \GuzzleHttp\json_encode($decoded);
        }

        return $this;
    }
}