<?php

namespace MammothMKIV\Validator;

abstract class ValidationConstraint
{
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
}