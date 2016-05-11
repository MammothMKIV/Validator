<?php

namespace MammothMKIV\Validator;

abstract class ValidationConstraint
{
    /**
     * @var string
     */
    protected $name;
    
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $fieldName
     * @param string $fieldDescription
     * @return string
     */
    public abstract function getErrorMessage($fieldName, $fieldDescription);

    /**
     * @param mixed $field
     * @return bool
     */
    public abstract function validate($field);

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}