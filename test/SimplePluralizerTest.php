<?php

require '../autoload.php';

class SimplePluralizerTest extends PHPUnit_Framework_TestCase
{
    public function testPluralizeSingle()
    {
        $string = 'Строка должна быть не короче ||||5|символ|символа|символов||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $result = $pluralizer->pluralize($string, 'ru');

        $this->assertEquals($result, 'Строка должна быть не короче 5 символов');
    }

    public function testPluralizeMultiple()
    {
        $string = 'Строка должна быть не короче ||||5|символ|символа|символов|||| и длинее ||||31|символа|символа|символов||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $result = $pluralizer->pluralize($string, 'ru');

        $this->assertEquals($result, 'Строка должна быть не короче 5 символов и длинее 31 символа');
    }

    public function testNonDefaultFormSeparator()
    {
        $string = 'Строка должна быть не короче ||||5||символ||символа||символов|||| и длинее ||||31||символа||символа||символов||||';
        $pluralizer = new \MammothMKIV\Validator\SimplePluralizer();
        $pluralizer->setDelimiter('||');
        $result = $pluralizer->pluralize($string, 'ru');

        $this->assertEquals($result, 'Строка должна быть не короче 5 символов и длинее 31 символа');
    }
}