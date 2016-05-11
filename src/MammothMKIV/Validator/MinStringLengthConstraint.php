<?php

namespace MammothMKIV\Validator;

class MinStringLengthConstraint extends ValidationConstraint
{
    private $minLength;

    public function __construct($minLength)
    {
        $this->minLength = $minLength;
    }

    /**
     * @param string $fieldName
     * @param string $fieldDescription
     * @return string
     */
    public function getErrorMessage($fieldName, $fieldDescription)
    {
        return sprintf('Поле %s не должно быть короче %d ' . Pluralizer::pluralize($this->minLength, 'символов', 'символа', 'символов'), $fieldDescription, $this->minLength);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value)
    {
        return is_string($value) && mb_strlen($value) >= $this->minLength;
    }
}