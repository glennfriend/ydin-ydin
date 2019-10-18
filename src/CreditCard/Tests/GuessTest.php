<?php

use PHPUnit\Framework\TestCase;
use Cor\Ydin\CreditCard\Guess;

class CreditCard_GuessTest extends TestCase
{
    /**
     *
     */
    public function test_guessCardNumber()
    {
        $cardType = Guess::cardType('4111111111111111');
        $this->assertEquals($cardType,'visa', 'visa card');

        $cardType = Guess::cardType('431196xxxxxx6690');
        $this->assertEquals($cardType,'visa', 'visa card');

        $cardType = Guess::cardType('515241xxxxxx6998');
        $this->assertEquals($cardType,'mastercard', 'mastercard card');
    }


}
