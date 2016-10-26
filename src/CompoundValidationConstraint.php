<?php

namespace MammothMKIV\Validator;

abstract class CompoundValidationConstraint
{
    /**
     * @var string[]
     */
    protected $fields;

    /**
     * @var string
     */
    protected $targetField;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * ValidationConstraint constructor.
     * @param string[] $fields
     * @param string $targetField
     */
    public function __construct($fields, $targetField)
    {
        $this->fields = $fields;
        $this->targetField = $targetField;
    }

    /**
     * @return string
     */
    public abstract function getErrorMessage();

    /**
     * @param $errorMessage
     * @return CompoundValidationConstraint
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @param mixed[] $fieldValues
     * @return bool
     */
    public abstract function validate($fieldValues);

    /**
     * @return string[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return string
     */
    public function getTargetField()
    {
        return $this->targetField;
    }
}