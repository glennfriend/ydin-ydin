<?php
declare(strict_types=1);

namespace Ydin\Csv;

/**
 * Convert
 *
 * @package Ydin\Csv
 */
class Convert
{

    /**
     * convert CSV headers
     */
    public static function headerConvert(array $headers): array
    {
        $convertNames = [];
        foreach ($headers as $index => $value) {
            $convertNames[$index] = static::normalNameCase($value);
        }

        $convertNames = static::convertEmptyNames($convertNames);
        $convertNames = static::convertRepeatNames($convertNames);
        return $convertNames;
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

    /**
     * 將 header name 轉為 小寫英文數字加上底線 的字串
     */
    private static function normalNameCase($value): string
    {
        // $value = str_replace('&', '_and_', $value);
        $value = preg_replace("/[@#&|\-\ ]/", "_", $value);

        // security convert
        $value = preg_replace("/[^a-zA-Z0-9_]+/", "", $value);
        $value = preg_replace("/[_]+/", "_", $value);
        $value = strtolower(trim($value, ' _'));
        return $value;
    }

    /**
     * 處理空值的名稱
     */
    private static function convertEmptyNames(array $rows): array
    {
        $result = [];
        foreach ($rows as $index => $name) {
            if (!$name) {
                $name = 'name_' . $index;
            }
            array_push($result, $name);
        }
        return $result;
    }

    /**
     * 處理重覆名稱問題
     */
    private static function convertRepeatNames(array $rows): array
    {
        $allowRow = [];
        foreach ($rows as $index => $name) {
            if (in_array($name, $allowRow)) {
                $name .= '_repeat_' . $index;
            }
            array_push($allowRow, $name);
        }
        return $allowRow;
    }

}
