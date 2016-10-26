<?php

class ValidatorIntegrationTest extends PHPUnit_Framework_TestCase
{
    public function testComplexValidation()
    {
        $validator = new \MammothMKIV\Validator\Validator();

        $validator->addField(
            new \MammothMKIV\Validator\PlainField(
                'test_field',
                'Test Field',
                new \MammothMKIV\Validator\NotEmptyConstraint(),
                new \MammothMKIV\Validator\MinStringLengthConstraint(1),
                new \MammothMKIV\Validator\MaxStringLengthConstraint(25)
            )
        );

        $validator->addField(new \MammothMKIV\Validator\ArrayField(
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

        $validator->addField((new \MammothMKIV\Validator\CompoundField(
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

        $validator->setData(array(
            'test_field' => '',
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

        $this->assertEquals(false, $validator->validate());

        $expected = array(
            'test_field' => array(
                'Test Field cannot be empty',
                'Test Field shouldn\'t be shorter than 1 character'
            ),
            'test_compound_field' => array(
                'nested_cmp_field' => array(
                    'password_confirmation' => array(
                        'All fields must be equal'
                    )
                )
            )
        );

        $this->assertEquals($expected, $validator->getErrors());
    }

    public function testRepeatedFieldValidation()
    {
        $validator = new \MammothMKIV\Validator\Validator();

        $validator->addCompoundValidationConstraint(
            new \MammothMKIV\Validator\RepeatedFieldConstraint(
                array(
                    'password',
                    'password_confirmation'
                ),
                'password_confirmation'
            )
        );

        $validator->setData(array(
            'password' => '123',
            'password_confirmation' => 'fffff'
        ));

        $validator->validate();

        $this->assertEquals(false, $validator->validate());

        $expected = array(
            'password_confirmation' => array(
                'All fields must be equal'
            )
        );

        $this->assertEquals($expected, $validator->getErrors());
    }

    public function testRepeatedFieldValid()
    {
        $validator = new \MammothMKIV\Validator\Validator();

        $validator->addCompoundValidationConstraint(
            new \MammothMKIV\Validator\RepeatedFieldConstraint(
                array(
                    'password',
                    'password_confirmation'
                ),
                'password_confirmation'
            )
        );

        $validator->setData(array(
            'password' => '123',
            'password_confirmation' => '123'
        ));

        $this->assertEquals(true, $validator->validate());

        $this->assertEquals(array(), $validator->getErrors());
    }
}