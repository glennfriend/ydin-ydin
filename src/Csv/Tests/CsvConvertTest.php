<?php

use PHPUnit\Framework\TestCase;
use Ydin\Csv\Convert as CsvConvert;

final class CsvConvertTest extends TestCase
{
    /**
     * @test
     */
    public function convert_space()
    {
        $headers = [
            ' id ',
            ' show me the   money ',
        ];
        $matchHeaders = [
            'id',
            'show_me_the_money',
        ];


        $result = CsvConvert::headerConvert($headers);
        $this->assertEquals($result, $matchHeaders);
    }

    /**
     * @test
     */
    public function convert_symbol()
    {
        $headers = [
            'id!@#$%&|',
        ];
        $matchHeaders = [
            'id',
        ];

        $result = CsvConvert::headerConvert($headers);
        $this->assertEquals($result, $matchHeaders);
    }

    /**
     * @test
     */
    public function convert_repeat_name()
    {
        $headers = [
            'id',
            'id',
            'hello',
            'id',
        ];
        $matchHeaders = [
            'id',
            'id_repeat_1',
            'hello',
            'id_repeat_3',
        ];

        $result = CsvConvert::headerConvert($headers);
        $this->assertEquals($result, $matchHeaders);
    }

}
