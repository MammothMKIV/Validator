<?php

namespace MammothMKIV\Validator;

class PlainField extends Field
{
    /**
     * @var ValidationConstraint[]
     */
    private $constraints;

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
    }

    /**
     * @param ValidationConstraint[] ...$constraints
     */
    public function addConstraints(ValidationConstraint... $constraints)
    {
        $this->constraints = array_merge($this->constraints, $constraints);
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