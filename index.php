<?php
require 'autoload.php';

$testValidator = new \MammothMKIV\Validator\Validator();

$testValidator->addField('test_field', 'Тестовое поле');

$testValidator->addConstraint(
    'test_field',
    new \MammothMKIV\Validator\NotEmptyConstraint(),
    new \MammothMKIV\Validator\MinStringLengthConstraint(1),
    new \MammothMKIV\Validator\MaxStringLengthConstraint(25)
);

$testValidator->setData(array('test_field' => ''));

$testValidator->validate();

var_dump($testValidator->validate(), $testValidator->getErrors());