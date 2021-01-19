<?php

use PHPUnit\Framework\TestCase;
use Ydin\Replace\EnglishWordShorteningStrategyReplace;

final class EnglishWordShorteningStrategyReplaceTest extends TestCase
{
    /**
     * @test
     */
    public function text_not_shortening()
    {
        $text = 'Village of Lots of People';
        $result = 'Village of Lots of People';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text));
    }

    /**
     * @test
     */
    public function text_is_null()
    {
        $text = 'Village of Lots of People';
        $result = null;
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text, 1));
    }

    /**
     * @test
     */
    public function text_1()
    {
        $text = 'Village of Lots of People';
        $result = 'VillageOfLotsOfPeople';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text,  strlen($result)));
    }

    /**
     * @test
     */
    public function text_2()
    {
        $text = 'Village of Lots of People';
        $result = 'VllgOfLtsOfPpl';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text,  strlen($result)));
    }

    /**
     * @test
     */
    public function text_3()
    {
        $text = 'Village of Lots of People';
        $result = 'VllgOfLtsOf';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text,  strlen($result)));
    }

    /**
     * @test
     */
    public function text_4()
    {
        $text = 'Village of Lots of People';
        $result = 'VllgOfLts';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text,  strlen($result)));
    }

    /**
     * @test
     */
    public function text_5()
    {
        $text = 'Village of Lots of People';
        $result = 'VllgOf';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text,  strlen($result)));
    }

    /**
     * @test
     */
    public function text_6()
    {
        $text = 'Village of Lots of People';
        $result = 'Vllg';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text,  strlen($result)));
    }

    /**
     * @test
     */
    public function text_dash()
    {
        $text = 'Hot-Springs-National-Park-is-city';
        $result = 'HtSprngs';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text, 10));
    }

    /**
     * @test
     */
    public function text_underlined()
    {
        $text = 'Hot_Springs_National_Park_is_city';
        $result = 'HtSprngs';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text, 10));
    }

    /**
     * @test
     */
    public function text_dot()
    {
        $text = 'Hot.Springs.National.Park.is.city';
        $result = 'HtSprngs';
        $this->assertEquals($result, EnglishWordShorteningStrategyReplace::shortening($text, 10));
    }

}
