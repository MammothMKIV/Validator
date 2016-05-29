<?php

namespace MammothMKIV\Validator;

class CompoundField extends Field
{
    /**
     * @var FieldList
     */
    private $fields;

    /**
     * @var CompoundValidationConstraint[]
     */
    private $constraints = array();

    /**
     * CompoundField constructor.
     * @param string $name
     * @param string $description
     * @param Field[] ...$fields
     */
    public function __construct($name, $description, Field... $fields)
    {
        parent::__construct($name, $description);
        $this->fields = new FieldList();

        $this->addFields($fields);
    }

    public function addConstraints(CompoundValidationConstraint... $constraints)
    {
        $this->constraints = array_merge($this->constraints, $constraints);
    }

    /**
     * @return CompoundValidationConstraint[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param Field|array ...$fields
     * @throws DuplicateFieldException
     */
    public function addFields($fields)
    {
        if (is_array($fields)) {
            foreach ((array)$fields as $field) {
                $this->fields->addField($field);
            }
        } else {
            $this->fields->addField($fields);
        }
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields->getFields();
    }
}