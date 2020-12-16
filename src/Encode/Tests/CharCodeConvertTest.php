<?php

use PHPUnit\Framework\TestCase;
use Ydin\Encode\CharCodeConvert;

final class CharCodeConvertTest extends TestCase
{
    /**
     *
     */
    public function test_numberToEnglish()
    {
        $this->assertEquals('cbddhbjaib', CharCodeConvert::numberToEnglish('2133719081'));
        $this->assertEquals('abcdefghij', CharCodeConvert::numberToEnglish('0123456789'));
        $this->assertEquals('(ajcb) ddd-eee', CharCodeConvert::numberToEnglish('(0921) 333-444'));
        $this->assertEquals('abc-xyz', CharCodeConvert::numberToEnglish('abc-xyz'));
        $this->assertEquals('abc-xyz', CharCodeConvert::numberToEnglish('012-xyz'));
        $this->assertEquals(
            'https://example/aab/hello/?phone=abcdefghij',
            CharCodeConvert::numberToEnglish('https://example/001/hello/?phone=0123456789')
        );
    }

    /**
     *
     */
    public function test_englishToNumber()
    {
        $this->assertEquals('0123456789', CharCodeConvert::englishToNumber('abcdefghij'));
        $this->assertEquals('(0921) 333-444', CharCodeConvert::englishToNumber('(ajcb) ddd-eee'));
        $this->assertEquals('012-xyz', CharCodeConvert::englishToNumber('abc-xyz'));
        $this->assertEquals('012-xyz', CharCodeConvert::englishToNumber('012-xyz'));
    }


}
