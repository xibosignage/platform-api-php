<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
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

        if (!$response = json_decode($response->getBody())) {
            $this->message = $response->getBody() . json_last_error_msg();
        } else {
            $this->message = $response->error->message;
        }

        return $this;
    }
}