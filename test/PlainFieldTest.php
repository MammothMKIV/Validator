<?php

require '../autoload.php';

class PlainFieldTest extends PHPUnit_Framework_TestCase
{
    public function testGetDescription()
    {
        $field = new \MammothMKIV\Validator\PlainField('test_field', 'Test Description');

        $this->assertEquals($field->getDescription(), 'Test Description');
    }

    public function testGetName()
    {
        $field = new \MammothMKIV\Validator\PlainField('test_field', 'Test Description');

        $this->assertEquals($field->getName(), 'test_field');
    }
}