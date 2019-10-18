<?php

use PHPUnit\Framework\TestCase;

class CreditCard_GuessTest extends TestCase
{
    /**
     *
     */
    public function test_guessCardNumber()
    {
        $cardType = Ydin\CreditCard\Guess::cardType('4111111111111111');
        $this->assertEquals($cardType,'visa', 'visa card');

        $cardType = Ydin\CreditCard\Guess::cardType('431196xxxxxx6690');
        $this->assertEquals($cardType,'visa', 'visa card');

        $cardType = Ydin\CreditCard\Guess::cardType('515241xxxxxx6998');
        $this->assertEquals($cardType,'mastercard', 'mastercard card');
    }


}
