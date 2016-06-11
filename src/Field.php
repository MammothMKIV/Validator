<?php

namespace MammothMKIV\Validator;

abstract class Field
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var boolean
     */
    protected $optional;

    /**
     * Field constructor.
     * @param string $name
     * @param string $description
     */
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param boolean $optional
     * @return Field
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isOptional()
    {
        return $this->optional;
    }
}