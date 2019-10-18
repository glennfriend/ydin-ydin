<?php

use PHPUnit\Framework\TestCase;

class Date_DayTest extends TestCase
{
    /**
     *  
     */
    public function test_inToday()
    {
        date_default_timezone_set('UTC');
    
        $this->assertEquals( true,  Ydin\Date\Day::inToday( time(),                   1), '距離現在, 在一天的時間內'                  );
        $this->assertEquals( false, Ydin\Date\Day::inToday( strtotime('2000-01-01'),  7), '現在, 距離這個日期, 在七天之內, 不可能'    );
    }

}
