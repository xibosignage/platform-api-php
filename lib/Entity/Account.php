<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (Account.php)
 */


namespace Xibo\Platform\Entity;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Account implements ResourceOwnerInterface, \JsonSerializable
{
    use EntityTrait;

    /** @var  int */
    protected $id;

    protected $name;
    protected $billingName;
    protected $billingEmail;

    /**
     * @var Account[]
     */
    protected $customers = [];

    /**
     * XiboUser constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if (count($attributes) > 1 && !array_key_exists('id', $attributes)) {
            // Hydrate this object
            $this->hydrate($attributes[0]);

            // This object has children?
            for ($i=1; $i < count($attributes); $i++) {
                $child = new Account($attributes[$i]);
                $this->customers[] = $child;
            }
        } else {
            // Hydrate this object
            $this->hydrate($attributes);
        }
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