<?php

namespace MammothMKIV\Validator;

class Validator
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var FieldList
     */
    private $fields;

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Validator constructor.
     */
    public function __construct()
    {
        $this->fields = new FieldList();
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function getVar($name)
    {
        if (is_array($this->data)) {
            return isset($this->data[$name]) ? $this->data[$name] : null;
        } elseif (is_object($this->data)) {
            return isset($this->data->$name) ? $this->data->$name : null;
        } else {
            throw new \Exception('Unknown data format');
        }
    }

    /**
     * @return boolean
     */
    public function validate()
    {
        $this->errors = array();

        foreach ($this->fields->getFields() as $fieldName => $field) {
            foreach ($field->getConstraints() as $constraint) {
                if (!$constraint->validate($this->getVar($fieldName))) {
                    if (!isset($this->errors[$fieldName])) {
                        $this->errors[$fieldName] = array();
                    }

                    $this->errors[$fieldName][] = $constraint->getErrorMessage($field->getName(), $field->getDescription());
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param Field $field
     * @throws DuplicateFieldException
     */
    public function addField(Field $field)
    {
        $this->fields->addField($field);
    }
}