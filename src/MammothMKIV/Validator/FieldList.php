<?php

namespace MammothMKIV\Validator;

class FieldList
{
    /**
     * @var array
     */
    private $fields;

    /**
     * FieldList constructor.
     */
    public function __construct()
    {
        $this->fields = array();
    }

    /**
     * @param Field $field
     * @throws DuplicateFieldException
     */
    public function addField(Field $field)
    {
        if (isset($this->fields[$field->getName()])) {
            throw new DuplicateFieldException('Field `' . $field->getName() . '` already exists');
        }

        $this->fields[$field->getName()] = $field;
    }

    /**
     * @param string $fieldName
     * @throws FieldNotFoundException
     */
    public function removeField($fieldName)
    {
        if (!isset($this->fields[$fieldName])) {
            throw new FieldNotFoundException('Field `' . $fieldName . '` does not exist');
        }

        unset($this->fields[$fieldName]);
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}