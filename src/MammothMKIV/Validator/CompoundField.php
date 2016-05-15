<?php

namespace MammothMKIV\Validator;

class CompoundField extends Field
{
    /**
     * @var FieldList
     */
    private $fields;

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

    /**
     * @param Field|array ...$fields
     * @throws DuplicateFieldException
     */
    public function addFields($fields)
    {
        foreach ((array)$fields as $field) {
            $this->fields->addField($field);
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