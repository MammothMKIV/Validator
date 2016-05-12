<?php

namespace MammothMKIV\Validator;

class ArrayField extends Field
{
    /**
     * @var FieldList
     */
    private $itemFields;

    /**
     * @var boolean
     */
    private $optional;

    /**
     * ArrayField constructor.
     * @param string $name
     * @param string $description
     * @param boolean $optional
     * @param Field[] $itemFields
     * @throws DuplicateFieldException
     */
    public function __construct($name, $description, $optional, Field... $itemFields)
    {
        parent::__construct($name, $description);
        $this->optional = $optional;
        $this->itemFields = new FieldList();

        foreach ($itemFields as $itemField) {
            $this->itemFields->addField($itemField);
        }
    }

    /**
     * @return FieldList
     */
    public function getItemFields()
    {
        return $this->itemFields;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return boolean
     */
    public function isOptional()
    {
        return $this->optional;
    }
}