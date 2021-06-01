<?php

use PHPUnit\Framework\TestCase;
use Ydin\Name\NameCaseConverter;

class NameCaseConverterTest extends TestCase
{
    /**
     * @test
     */
    public function convert()
    {
        $text = 'hello world';

        $this->assertEquals('Hello World', NameCaseConverter::title($text));
        $this->assertEquals('hello world', NameCaseConverter::lower($text));

        $this->assertEquals('helloworld', NameCaseConverter::lowerAndNoSymbol($text));
        $this->assertEquals('HelloWorld', NameCaseConverter::pascal($text));
        $this->assertEquals('hello-world', NameCaseConverter::kebab($text));

        $this->assertEquals('hello_world', NameCaseConverter::snake($text));
        $this->assertEquals('HELLO_WORLD', NameCaseConverter::micro($text));
    }

}
