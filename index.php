<?php
require 'autoload.php';

$testValidator = new \MammothMKIV\Validator\Validator();

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
    new \MammothMKIV\Validator\CompoundField(
        'nested_cmp_field',
        'Nested Compound Field',
        new \MammothMKIV\Validator\PlainField(
            'cmp_plain_field',
            'Compound Plain Field',
            new \MammothMKIV\Validator\NotEmptyConstraint(),
            new \MammothMKIV\Validator\MinStringLengthConstraint(1),
            new \MammothMKIV\Validator\MaxStringLengthConstraint(25)
        )
    )))->setOptional(true)
);

$testValidator->setData(array(
    'test_field' => 'www',
    'test_array_field' => array(
        array(
            'plain_field1' => 'Test1',
            'test_array_field_2' => array(
                array(
                    'plain_field2' => '2132131131df'
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
            'cmp_plain_field' => '1sadasdasdasdasdasdadasdasdasdasdasdasda',
        )
    )
));

$testValidator->validate();

echo json_encode($testValidator->getErrors(), JSON_PRETTY_PRINT);