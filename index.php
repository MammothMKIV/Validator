<?php
require 'autoload.php';

$testValidator = new \MammothMKIV\Validator\Validator('en', new \MammothMKIV\Validator\SimpleTranslator());

$testValidator->addField(
    new \MammothMKIV\Validator\PlainField(
        'test_field',
        'Test Field',
        new \MammothMKIV\Validator\NotEmptyConstraint(),
        new \MammothMKIV\Validator\MinStringLengthConstraint(1),
        new \MammothMKIV\Validator\MaxStringLengthConstraint(25)
    )
);

$testValidator->addField(new \MammothMKIV\Validator\ArrayField(
    'test_array_field',
    'Test Array Field',
    true,
    new \MammothMKIV\Validator\PlainField(
        'plain_field1',
        'Plain Field 1',
        new \MammothMKIV\Validator\NotEmptyConstraint(),
        new \MammothMKIV\Validator\MinStringLengthConstraint(5),
        new \MammothMKIV\Validator\MaxStringLengthConstraint(10)
    ),
    new \MammothMKIV\Validator\ArrayField(
        'test_array_field_2',
        'Test Array Field 2',
        true,
        new \MammothMKIV\Validator\PlainField(
            'plain_field2',
            'Plain Field 2',
            new \MammothMKIV\Validator\NotEmptyConstraint(),
            new \MammothMKIV\Validator\MinStringLengthConstraint(1),
            new \MammothMKIV\Validator\MaxStringLengthConstraint(25)
        )
    )
));

$nestedCompoundField = new \MammothMKIV\Validator\CompoundField(
    'nested_cmp_field',
    'Nested Compound Field',
    new \MammothMKIV\Validator\PlainField(
        'cmp_plain_field',
        'Compound Plain Field',
        new \MammothMKIV\Validator\NotEmptyConstraint(),
        new \MammothMKIV\Validator\MinStringLengthConstraint(1),
        new \MammothMKIV\Validator\MaxStringLengthConstraint(25)
    )
);
$nestedCompoundField->addConstraints(new \MammothMKIV\Validator\RepeatedFieldConstraint(array('password', 'password_confirmation'), 'password_confirmation'));

$testValidator->addField((new \MammothMKIV\Validator\CompoundField(
    'test_compound_field',
    'Test Compound Field',
    new \MammothMKIV\Validator\PlainField(
        'cmp_plain_field',
        'Compound Plain Field',
        new \MammothMKIV\Validator\NotEmptyConstraint(),
        new \MammothMKIV\Validator\MinStringLengthConstraint(1),
        new \MammothMKIV\Validator\MaxStringLengthConstraint(25)
    ),
    $nestedCompoundField))->setOptional(true)
);

$testValidator->setData(array(
    'test_field' => 'www',
    'test_array_field' => array(
        array(
            'plain_field1' => 'Test1',
            'test_array_field_2' => array(
                array(
                    'plain_field2' => '213dfgdfgdfgd131df'
                )
            )
        ),
        array('plain_field1' => 'sssss'),
        array('plain_field1' => 'sssss'),
        array('plain_field1' => 'Test ad '),
    ),
    'test_compound_field' => array(
        'cmp_plain_field' => '1',
        'nested_cmp_field' => array(
            'cmp_plain_field' => '1sadvghccvhvchhvchcssda',
            'password' => 1253,
            'password_confirmation' => 123
        )
    )
));

$testValidator->validate();

echo json_encode($testValidator->getErrors(), JSON_PRETTY_PRINT);

$testValidator2 = new \MammothMKIV\Validator\Validator('en', new \MammothMKIV\Validator\SimpleTranslator());

$testValidator2->addCompoundValidationConstraint(new \MammothMKIV\Validator\RepeatedFieldConstraint(array('password', 'password_confirmation'), 'password_confirmation'));

$testValidator2->setData(array(
    'password' => '123',
    'password_confirmation' => 'fffff'
));

$testValidator2->validate();

echo json_encode($testValidator2->getErrors(), JSON_PRETTY_PRINT);