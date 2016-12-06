<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (Account.php)
 */


namespace Entity;


class Account
{
    /** @var  int */
    protected $id;

    /**
     * XiboUser constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->id = $attributes['id'];
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