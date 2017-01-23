<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (EntityTrait.php)
 */


namespace Xibo\Platform\Entity;


trait EntityTrait
{
    private $jsonExclude = ['buttons', 'jsonExclude', 'originalValues'];

    /** @var array Original values hydrated */
    protected $originalValues = [];

    /**
     * Hydrate an entity with properties
     *
     * @param array $properties
     * @param array $options
     *
     * @return self
     */
    public function hydrate(array $properties, $options = [])
    {
        $intProperties = (array_key_exists('intProperties', $options)) ? $options['intProperties'] : [];
        $stringProperties = (array_key_exists('stringProperties', $options)) ? $options['stringProperties'] : [];
        $htmlStringProperties = (array_key_exists('htmlStringProperties', $options)) ? $options['htmlStringProperties'] : [];

        foreach ($properties as $prop => $val) {
            if (property_exists($this, $prop)) {

                if ((stripos(strrev($prop), 'dI') === 0 || in_array($prop, $intProperties)) && !in_array($prop, $stringProperties))
                    $val = intval($val);
                else if (in_array($prop, $stringProperties))
                    $val = filter_var($val, FILTER_SANITIZE_STRING);
                else if (in_array($prop, $htmlStringProperties))
                    $val = htmlentities($val);

                $this->{$prop} =  $val;
                $this->originalValues[$prop] = $val;
            }
        }

        return $this;
    }

    /**
     * Get the original value of a property
     * @param string $property
     * @return null|mixed
     */
    public function getOriginalValue($property)
    {
        return (isset($this->originalValues[$property])) ? $this->originalValues[$property] : null;
    }

    /**
     * Has the provided property been changed from its original value
     * @param string $property
     * @return bool
     */
    public function hasPropertyChanged($property)
    {
        if (!property_exists($this, $property))
            return true;

        return $this->getOriginalValue($property) != $this->{$property};
    }

    /**
     * Json Serialize
     * @return array
     */
    public function jsonSerialize()
    {
        $exclude = $this->jsonExclude;

        $properties = get_object_vars($this);
        $json = [];
        foreach ($properties as $key => $value) {
            if (!in_array($key, $exclude)) {
                $json[$key] = $value;
            }
        }
        return $json;
    }

    /**
     * To Array
     * @return array
     */
    public function toArray()
    {
        return $this->jsonSerialize();
    }

    /**
     * Add a property to the excluded list
     * @param string $property
     */
    public function excludeProperty($property)
    {
        $this->jsonExclude[] = $property;
    }

    /**
     * Remove a property from the excluded list
     * @param string $property
     */
    public function includeProperty($property)
    {
        $this->jsonExclude = array_diff($this->jsonExclude, [$property]);
    }
}