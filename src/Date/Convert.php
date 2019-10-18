<?php
declare(strict_types=1);
namespace Ydin\Date;

use Exception;
use DateTime;
use DateTimeZone;

/**
 * Convert
 *
 * @version 1.0.0
 * @package Ydin\Date\Convert
 */
class Convert
{

    /**
     *  時區轉換
     *
     *  將一個 time value (int) 代入, 並給予該 temestamp 的時區, 與轉換目的之時區
     *  傳回 目的時區 timestamp
     *
     *  一個簡單的例子表示 fromat 相對 timezone 的 timestamp 值
     *      "1970-01-01 00:00:00"
     *          - Asia/Taipei           -28800  嬌正 +8
     *          - UTC                   0       嬌正 +0
     *          - America/Los_Angeles   28800   嬌正 -8
     *
     *  @string $timeString - timestamp int
     *  @string $from       - timezone string
     *  @string $to         - timezone string
     *  @return int
     */
    public static function timezone($timestamp, $from, $to)
    {
        try {
            $tz1 = new DateTime('now', new DateTimeZone($from));
            $tz2 = new DateTime('now', new DateTimeZone($to));
            $offset = $tz2->getOffset() - $tz1->getOffset();
            return $timestamp + $offset;
        }
        catch (Exception $e) {
            // error
        }

        return 0;
    }
}
