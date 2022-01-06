<?php

namespace Ydin\ThirdParty\Laravel\Console\Concerns\Tests;

use Tests\TestCase;
use Ydin\ThirdParty\Laravel\Console\Concerns\ConsoleParameterized;

class ConsoleParameterizedTest extends TestCase
{
    use ConsoleParameterized;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function parse()
    {
        // NOTE: getAllParams() 因為 static 宣告的關系, 資料會被 cache, 必須找出 phpunit 如何重新設定值的問題
        $row = $this->getAllParams('xyz');
        $this->assertEquals([], $row);

        $row = $this->getAllParams('custom');
        $this->assertEquals('747-217-7784', $row['myAccount']);
        $this->assertEquals([17, 31], $row['items']);
        $this->assertEquals('City', $row['name']);
        $this->assertEquals(true, $row['boolData']);
        $this->assertEquals(false, $row['boolData2']);
        $this->assertEquals(null, $row['nullData']);
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

    // Illuminate\Console\Command
    protected function arguments(): array
    {
        return [
            "custom" => [
                "myAccount=747-217-7784",
                "items=[17, 31]",
                "name=City",
                "boolData=true",
                "boolData2=false",
                "nullData=null",
            ],
        ];
    }
}
