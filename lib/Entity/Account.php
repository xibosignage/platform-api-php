<?php
/*
 * Xibo Signage Ltd - https://xibo.org.uk
 * Copyright (C) 2016 Xibo Signage Ltd
 * (Account.php)
 */


namespace Xibo\Platform\Entity;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Account implements ResourceOwnerInterface, \JsonSerializable
{
    use EntityTrait;

    /** @var  int */
    public $id;

    /** @var string Associated UserName */
    public $userName;

    /** @var int Channel Partner Company Id */
    public $companyId;

    /** @var string API client name */
    public $clientName;

    /**
     * XiboUser constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        // Hydrate this object
        $this->hydrate($attributes);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}