<?php

class SimplePluralizerEnTest extends PHPUnit_Framework_TestCase
{
    public function testPluralizeSingle()
    {
        $string = 'String shouldn\'t be shorter than ||||5|character|characters||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $result = $pluralizer->pluralize($string, 'en');

        $this->assertEquals('String shouldn\'t be shorter than 5 characters', $result);
    }

    public function testPluralizeMultiple()
    {
        $string = 'String shouldn\'t be shorter than ||||1|character|characters|||| and longer than ||||31|character|characters||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $result = $pluralizer->pluralize($string, 'en');

        $this->assertEquals('String shouldn\'t be shorter than 1 character and longer than 31 characters', $result);
    }

    public function testNonDefaultFormSeparator()
    {
        $string = 'String shouldn\'t be shorter than ||||5||character||characters|||| and longer than ||||31||character||characters||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $pluralizer->setDelimiter('||');
        $result = $pluralizer->pluralize($string, 'en');

        $this->assertEquals('String shouldn\'t be shorter than 5 characters and longer than 31 characters', $result);
    }
}