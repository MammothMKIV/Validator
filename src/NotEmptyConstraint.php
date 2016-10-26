<?php

namespace MammothMKIV\Validator;

class NotEmptyConstraint extends ValidationConstraint
{
    /**
     * NotEmptyConstraint constructor.
     * @param string $name
     */
    public function __construct($name = 'not_empty')
    {
        parent::__construct($name, '%s cannot be empty');
    }

    /**
     * @param string $fieldName
     * @param string $fieldDescription
     * @return string
     */
    public function getErrorMessage($fieldName, $fieldDescription)
    {
        return sprintf($this->errorMessage, $fieldDescription);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value)
    {
        return isset($value) && !empty($value);
    }
}