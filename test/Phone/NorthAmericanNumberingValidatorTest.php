<?php

use PHPUnit\Framework\TestCase;
use Cor\Ydin\Phone\NorthAmericanNumberingValidator;

class Phone_NorthAmericanNumberingValidator_Test extends TestCase
{

    /**
     *  @dataProvider check_usa_phone_number
     */
    public function test_usa_phone_number($result, $number)
    {
        $this->assertEquals($result, NorthAmericanNumberingValidator::isValid($number));
    }

    public function check_usa_phone_number()
    {
        return [
            [true,  '8556777305'],
            [true,  '8558888888'],
            [true,  '2018888888'],

            [false, '8536777305'],
            [false, '0238888888'],
            [false, '1238888888'],
            [false, '2118888888'],
            [false, '3118888888'],
            [false, '4118888888'],
        ];
    }

}
