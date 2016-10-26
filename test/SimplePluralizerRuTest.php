<?php

class SimplePluralizerRuTest extends PHPUnit_Framework_TestCase
{
    public function testPluralizeSingle()
    {
        $string = 'Строка должна быть не короче ||||5|символ|символа|символов||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $result = $pluralizer->pluralize($string, 'ru');

        $this->assertEquals('Строка должна быть не короче 5 символов', $result);
    }

    public function testPluralizeMultiple()
    {
        $string = 'Строка должна быть не короче ||||5|символ|символа|символов|||| и длинее ||||31|символа|символа|символов||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $result = $pluralizer->pluralize($string, 'ru');

        $this->assertEquals('Строка должна быть не короче 5 символов и длинее 31 символа', $result);
    }

    public function testNonDefaultFormSeparator()
    {
        $string = 'Строка должна быть не короче ||||5||символ||символа||символов|||| и длинее ||||31||символа||символа||символов||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $pluralizer->setDelimiter('||');
        $result = $pluralizer->pluralize($string, 'ru');

        $this->assertEquals('Строка должна быть не короче 5 символов и длинее 31 символа', $result);
    }
}