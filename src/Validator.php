<?php

namespace MammothMKIV\Validator;

class Validator
{
    /**
     * @var object|array
     */
    private $data;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var CompoundField
     */
    private $rootField;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @param object|array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Validator constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator = null)
    {
        $this->fields = new FieldList();

        if (!$translator) {
            $translator = new SimpleTranslator();
        }

        $this->translator = $translator;

        $this->rootField = new CompoundField('root', '');
    }

    /**
     * @param Translator $translator
     */
    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param string $name
     * @param object|array $data
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

    /**
     * @param string[] $names
     * @param object|array $data
     * @return mixed
     */
    public function getVars($names, $data)
    {
        $results = array();

        foreach ($names as $name) {
            if (is_array($data)) {
                $results[$name] = isset($data[$name]) ? $data[$name] : null;
            } elseif (is_object($data)) {
                $results[$name] = isset($data->$name) ? $data->$name : null;
            } else {
                $results[$name] = null;
            }
        }

        return $results;
    }

    /**
     * @param array $fields
     * @param array $data
     * @param array $errors
     */
    protected function validateFields($fields, $data, &$errors)
    {
        foreach ($fields as $fieldName => $field) {
            if ($field instanceof PlainField) {
                foreach ($field->getConstraints() as $constraint) {
                    if (!$constraint->validate($this->getVar($fieldName, $data))) {
                        if (!isset($errors[$fieldName])) {
                            $errors[$fieldName] = array();
                        }

                        $errors[$fieldName][] = $this->translator->translate($constraint->getErrorMessage($field->getName(), $field->getDescription()));
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

                $constraints = $field->getConstraints();

                foreach ($constraints as $constraint) {
                    $fieldNames = $constraint->getFields();
                    $keyValues = $this->getVars($fieldNames, $keyValues);

                    $isValid = $constraint->validate($keyValues);

                    if (!$isValid) {
                        if (!isset($errors[$fieldName])) {
                            $errors[$fieldName][$constraint->getTargetField()] = array();
                        }

                        if (!isset($errors[$fieldName][$constraint->getTargetField()])) {
                            $errors[$fieldName][$constraint->getTargetField()] = array();
                        }

                        $errors[$fieldName][$constraint->getTargetField()][] = $this->translator->translate($constraint->getErrorMessage());
                    }
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

        $this->validateFields(array('root' => $this->rootField), array('root' => $this->data), $this->errors);

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return empty($this->errors) ? array() : $this->errors['root'];
    }

    /**
     * @return CompoundField
     */
    public function getRootField()
    {
        return $this->rootField;
    }

    /**
     * @param Field $field
     * @throws DuplicateFieldException
     */
    public function addField(Field $field)
    {
        $this->rootField->addFields($field);
    }

    /**
     * @param CompoundValidationConstraint $constraint
     */
    public function addCompoundValidationConstraint(CompoundValidationConstraint $constraint)
    {
        $this->rootField->addConstraints($constraint);
    }
}