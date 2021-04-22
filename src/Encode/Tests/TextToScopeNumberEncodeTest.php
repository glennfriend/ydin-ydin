<?php

use PHPUnit\Framework\TestCase;
use Ydin\Encode\TextToScopeNumberEncode;

final class TextToScopeNumberEncodeTest extends TestCase
{
    /**
     *
     */
    public function test_StringToSerialNumberEncode()
    {
        /*
        // 統計資料
        $statistics = [];
        for ($i = 0; $i < 990000; $i++) {
            $key = TextToScopeNumberEncode::build((string)rand(10000, 90000));
            if (!isset($statistics[$key])) {
                $statistics[$key] = 0;
            }
            $statistics[$key]++;
        }
        ksort($statistics);
        print_r($statistics);
        */

        $value = TextToScopeNumberEncode::build('text1', 5);
        $this->assertTrue(true === in_array($value, [0,1,2,3,4]));

        $value = TextToScopeNumberEncode::build('text2', 5);
        $this->assertTrue(true === in_array($value, [0,1,2,3,4]));

        $value = TextToScopeNumberEncode::build('text3', 5);
        $this->assertTrue(true === in_array($value, [0,1,2,3,4]));
    }

}
