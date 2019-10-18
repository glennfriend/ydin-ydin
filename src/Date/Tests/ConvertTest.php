<?php

use PHPUnit\Framework\TestCase;

class Date_ConvertTest extends TestCase
{
    /**
     * @test
     * @group date
     */
    public function convert_timezone()
    {
        date_default_timezone_set('UTC');

        $utc_to_taipei = Ydin\Date\Convert::timezone(0, 'UTC', 'Asia/Taipei');
        $taipei_to_utc = Ydin\Date\Convert::timezone(0, 'Asia/Taipei', 'UTC');

        $this->assertEquals(  8 * 3600, $utc_to_taipei, 'UTC to taipei 時區轉換錯誤');
        $this->assertEquals( -8 * 3600, $taipei_to_utc, 'taipei to UTC 時區轉換錯誤');
    }

}
