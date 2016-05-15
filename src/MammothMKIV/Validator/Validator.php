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
     * @param mixed $data
     * @return mixed
     * @throws \Exception
     */
    public function getVar($name, $data)
    {
        if (is_array($data)) {
            return isset($data[$name]) ? $data[$name] : null;
        } elseif (is_object($data)) {
            return isset($data->$name) ? $data->$name : null;
        } else {
            return null;
        }
    }

    protected function validateFields($fields, $data, &$errors)
    {
        foreach ($fields as $fieldName => $field) {
            if ($field instanceof PlainField) {
                foreach ($field->getConstraints() as $constraint) {
                    if (!$constraint->validate($this->getVar($fieldName, $data))) {
                        if (!isset($errors[$fieldName])) {
                            $errors[$fieldName] = array();
                        }

                        $errors[$fieldName][] = $constraint->getErrorMessage($field->getName(), $field->getDescription());
                    }
                }
            } elseif ($field instanceof ArrayField) {
                $items = $this->getVar($fieldName, $data);

                if ($items === null && $field->isOptional()) {
                    continue;
                }

                if (!isset($errors[$fieldName])) {
                    $errors[$fieldName] = array();
                }

                if (!is_array($items)) {
                    $errors[$fieldName][] = sprintf('%s is not an array', $field->getDescription());
                    continue;
                }

                if (!empty($items) && !is_array(reset($items))) {
                    $errors[$fieldName][] = sprintf('Invalid array item in %s', $field->getDescription());
                    continue;
                }

                foreach ($items as $index => $item) {
                    $err = array();
                    $this->validateFields($field->getItemFields()->getFields(), $item, $err);

                    if ($err) {
                        $errors[$fieldName]['item_' . $index] = $err;
                    }
                }

                if (count($errors[$fieldName]) === 0) {
                    unset($errors[$fieldName]);
                }
            } elseif ($field instanceof CompoundField) {
                $keyValues = $this->getVar($fieldName, $data);

                if ($keyValues === null && $field->isOptional()) {
                    continue;
                }

                if (!isset($errors[$fieldName])) {
                    $errors[$fieldName] = array();
                }

                if (!is_array($keyValues)) {
                    $errors[$fieldName][] = sprintf('%s is not an array', $field->getDescription());
                    continue;
                }

                $err = array();
                $this->validateFields($field->getFields(), $keyValues, $err);

                if ($err) {
                    $errors[$fieldName] = $err;
                }

                if (count($errors[$fieldName]) === 0) {
                    unset($errors[$fieldName]);
                }
            }
        }
    }

    /**
     * @return boolean
     */
    public function validate()
    {
        $this->errors = array();

        $this->validateFields($this->fields->getFields(), $this->data, $this->errors);

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