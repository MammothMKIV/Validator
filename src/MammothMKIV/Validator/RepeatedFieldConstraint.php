<?php

namespace MammothMKIV\Validator;

class RepeatedFieldConstraint extends CompoundValidationConstraint
{
    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return 'All fields must be equal';
    }

    /**
     * @param mixed[] $fieldValues
     * @return bool
     */
    public function validate($fieldValues)
    {
        $previous = '';

        $first = true;
        foreach ($this->fields as $field) {
            $value = $fieldValues[$field];
            
            if ($first) {
                $first = false;
                $previous = $value;
                continue;
            }

            if ($previous != $value) {
                return false;
            }

            $previous = $value;
        }

        return true;
    }
}