<?php

namespace MammothMKIV\Validator;

class NotEmptyConstraint extends ValidationConstraint
{
    /**
     * @param string $fieldName
     * @param string $fieldDescription
     * @return string
     */
    public function getErrorMessage($fieldName, $fieldDescription)
    {
        return sprintf('Поле %s не может быть пустым', $fieldDescription);
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