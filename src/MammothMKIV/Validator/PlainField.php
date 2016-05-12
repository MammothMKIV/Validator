<?php

namespace MammothMKIV\Validator;

class PlainField extends Field
{
    /**
     * @var ValidationConstraint[]
     */
    private $constraints;

    /**
     * @var FieldList
     */
    private $childFields;

    /**
     * Field constructor.
     * @param string $name
     * @param string $description
     * @param ValidationConstraint[] ...$constraints
     */
    public function __construct($name, $description, ValidationConstraint... $constraints)
    {
        parent::__construct($name, $description);
        $this->constraints = $constraints;
        
        $this->childFields = new FieldList();
    }

    /**
     * @param ValidationConstraint[] ...$constraints
     */
    public function addConstraints(ValidationConstraint... $constraints)
    {
        $this->constraints = array_merge($this->constraints, $constraints);
    }

    /**
     * @param Field[] ...$fields
     * @throws DuplicateFieldException
     */
    public function addChildren(Field... $fields)
    {
        foreach ($fields as $field) {
            $this->childFields->addField($field);
        }
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->childFields->getFields();
    }

    /**
     * @param string $constraintName
     */
    public function removeConstraint($constraintName)
    {
        foreach ($this->constraints as $key => $constraint) {
            if ($constraint->getName() === $constraintName) {
                unset($this->constraints[$key]);
            }
        }

        $this->constraints = array_values($this->constraints);
    }

    /**
     * @return ValidationConstraint[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }
}