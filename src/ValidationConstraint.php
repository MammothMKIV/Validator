<?php

namespace MammothMKIV\Validator;

abstract class ValidationConstraint
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * ValidationConstraint constructor.
     * @param string $name
     * @param string $errorMessage
     */
    public function __construct($name, $errorMessage)
    {
        $this->name = $name;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param string $fieldName
     * @param string $fieldDescription
     * @return string
     */
    public abstract function getErrorMessage($fieldName, $fieldDescription);

    /**
     * @param string $errorMessage
     * @return ValidationConstraint
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

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