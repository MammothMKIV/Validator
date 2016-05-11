<?php

namespace MammothMKIV\Validator;

class MaxStringLengthConstraint extends ValidationConstraint
{
    private $maxLength;

    /**
     * @param string $fieldName
     * @param string $fieldDescription
     * @return string
     */
    public function getErrorMessage($fieldName, $fieldDescription)
    {
        return sprintf('Поле %s не должно быть длинее %d ' . Pluralizer::pluralize($this->maxLength, 'символов', 'символа', 'символов'), $fieldDescription, $this->maxLength);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value)
    {
        return is_string($value) && mb_strlen($value) <= $this->maxLength;
    }
}