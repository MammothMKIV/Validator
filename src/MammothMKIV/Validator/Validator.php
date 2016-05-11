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
    private $constraints;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
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
     * @param string $fieldName
     * @param ValidationConstraint|ValidationConstraint[] ...$constraints
     * @throws \Exception
     */
    public function addConstraint($fieldName, ValidationConstraint... $constraints)
    {
        if (!isset($this->fields[$fieldName])) {
            throw new \Exception('Field `' . $fieldName . '` does not exist');
        }

        if (!isset($this->constraints[$fieldName])) {
            $this->constraints[$fieldName] = array();
        }

        $this->constraints[$fieldName] = array_merge($this->constraints[$fieldName], $constraints);
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

    public function getFieldDescription($fieldName)
    {
        if (isset($this->fields[$fieldName])) {
            return $this->fields[$fieldName];
        } else {
            throw new \Exception('Field with such ID does not exist');
        }
    }

    /**
     * @return boolean
     */
    public function validate()
    {
        $this->errors = array();

        foreach ($this->constraints as $fieldName => $constraintList) {
            foreach ($constraintList as $constraint) {
                if (!$constraint->validate($this->getVar($fieldName))) {
                    if (!isset($this->errors[$fieldName])) {
                        $this->errors[$fieldName] = array();
                    }

                    $this->errors[$fieldName][] = $constraint->getErrorMessage($fieldName, $this->getFieldDescription($fieldName));
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

    public function addField($fieldName, $fieldDescription)
    {
        if (!isset($this->fields[$fieldName])) {
            $this->fields[$fieldName] = $fieldDescription;
        } else {
            throw new \Exception('Field with such ID already exists');
        }
    }
}