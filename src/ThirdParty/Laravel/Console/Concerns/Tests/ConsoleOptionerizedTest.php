<?php

namespace Ydin\ThirdParty\Laravel\Console\Concerns\Tests;

use Tests\TestCase;
use Ydin\ThirdParty\Laravel\Console\Concerns\ConsoleOptionerized;

class ConsoleOptionerizedTest extends TestCase
{
    use ConsoleOptionerized;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function parse()
    {
        $row = $this->getCustomOptions();
        $this->assertEquals('747-217-7784', $row['myAccount']);
        $this->assertEquals([17, 31], $row['items']);
        $this->assertEquals('City', $row['name']);
        $this->assertEquals(true, $row['boolData']);
        $this->assertEquals(false, $row['boolData2']);
        $this->assertTrue(is_array($row['options']));
        $this->assertEquals('111', $row['options']['expandFrom']);
        $this->assertEquals('222', $row['options']['changeFrom']);
        $this->assertEquals(true, $row['options']['useLocalPhoneNumbers']);
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

    protected function getIlluminateConsoleOptions(): array
    {
        return [
            "myAccount"                     => "747-217-7784",
            "items"                         => "[17, 31]",
            "name"                          => "City",
            "boolData"                      => "true",
            "boolData2"                     => "false",
            "nullData"                      => "null",
            "options[expandFrom]"           => "111",
            "options[changeFrom]"           => "222",
            "options[useLocalPhoneNumbers]" => true,
        ];
    }
}
