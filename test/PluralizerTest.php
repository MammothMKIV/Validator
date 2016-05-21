<?php

require '../autoload.php';

class PluralizerTest extends PHPUnit_Framework_TestCase
{
    public function testPluralizeSingle()
    {
        $string = 'Строка должна быть не короче ||||5|символ|символа|символов||||';
        $pluralizer = new \MammothMKIV\Validator\Pluralizer('ru');
        $result = $pluralizer->pluralize($string);

        $this->assertEquals($result, 'Строка должна быть не короче 5 символов');
    }

    public function testPluralizeMultiple()
    {
        $string = 'Строка должна быть не короче ||||5|символ|символа|символов|||| и длинее ||||31|символа|символа|символов||||';
        $pluralizer = new \MammothMKIV\Validator\Pluralizer('ru');
        $result = $pluralizer->pluralize($string);

        $this->assertEquals($result, 'Строка должна быть не короче 5 символов и длинее 31 символа');
    }

    public function testNonDefaultFormSeparator()
    {
        $string = 'Строка должна быть не короче ||||5||символ||символа||символов|||| и длинее ||||31||символа||символа||символов||||';
        $pluralizer = new \MammothMKIV\Validator\Pluralizer('ru');
        $pluralizer->setDelimiter('||');
        $result = $pluralizer->pluralize($string);

        $this->assertEquals($result, 'Строка должна быть не короче 5 символов и длинее 31 символа');
    }
}