<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (NotFoundException.php)
 */


namespace Xibo\Platform\Api\Error;

use Exception;

class NotFoundException extends ApiException
{
    protected $code = 404;

    public function __construct($message = 'Not Found', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}