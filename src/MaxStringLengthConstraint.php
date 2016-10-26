<?php

namespace MammothMKIV\Validator;

class MaxStringLengthConstraint extends ValidationConstraint
{
    /**
     * @var integer
     */
    private $maxLength;

    /**
     * MaxStringLengthConstraint constructor.
     * @param integer $maxLength
     * @param string $name
     */
    public function __construct($maxLength, $name = 'max_length')
    {
        parent::__construct($name, '%s shouldn\'t be longer than ||||%d|character|characters||||');
        $this->maxLength = $maxLength;
    }

    /**
     * @param string $fieldName
     * @param string $fieldDescription
     * @return string
     */
    public function getErrorMessage($fieldName, $fieldDescription)
    {
        return sprintf($this->errorMessage, $fieldDescription, $this->maxLength);
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