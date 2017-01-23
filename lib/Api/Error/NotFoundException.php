<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (NotFoundException.php)
 */


namespace Xibo\Platform\Api\Error;


class NotFoundException extends ApiException
{
    protected $code = 404;
    public $entity = null;

    public function __construct($message = 'Not Found', $entity = null)
    {
        $this->entity = $entity;

        parent::__construct($message, $this->code);
    }
}