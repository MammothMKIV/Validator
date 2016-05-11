<?php

require '../autoload.php';

class FieldTest extends PHPUnit_Framework_TestCase
{
    public function testGetDescription()
    {
        $field = new \MammothMKIV\Validator\Field('test_field', 'Test Description');

        $this->assertEquals($field->getDescription(), 'Test Description');
    }

    public function testGetName()
    {
        $field = new \MammothMKIV\Validator\Field('test_field', 'Test Description');

        $this->assertEquals($field->getName(), 'test_field');
    }
}