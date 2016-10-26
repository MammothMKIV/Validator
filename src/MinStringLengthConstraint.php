<?php

namespace MammothMKIV\Validator;

class MinStringLengthConstraint extends ValidationConstraint
{
    /**
     * @var integer
     */
    private $minLength;

    /**
     * MinStringLengthConstraint constructor.
     * @param integer $minLength
     * @param string $name
     */
    public function __construct($minLength, $name = 'min_length')
    {
        parent::__construct($name, '%s shouldn\'t be shorter than ||||%d|character|characters||||');
        $this->minLength = $minLength;
    }

    /**
     * @param string $fieldName
     * @param string $fieldDescription
     * @return string
     */
    public function getErrorMessage($fieldName, $fieldDescription)
    {
        return sprintf($this->errorMessage, $fieldDescription, $this->minLength);
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