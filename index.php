<?php
require 'autoload.php';

$testValidator = new \MammothMKIV\Validator\Validator();

$testValidator->addField(
    new \MammothMKIV\Validator\Field(
        'test_field',
        'Test Field',
        new \MammothMKIV\Validator\NotEmptyConstraint(),
        new \MammothMKIV\Validator\MinStringLengthConstraint(1),
        new \MammothMKIV\Validator\MaxStringLengthConstraint(25)
    )
);

$testValidator->setData(array('test_field' => ''));

$testValidator->validate();

var_dump($testValidator->validate(), $testValidator->getErrors());