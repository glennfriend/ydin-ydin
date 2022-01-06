<?php

declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Console\Concerns;

use Exception;

/**
 * Illuminate\Console\Command 提供了陣列化的輸入格式
 *
 *      $signature = 'prefix:command-name {custom*}'
 *
 * 配合上任意參數的輸入
 *
 *      參閱 ConsoleParameterized.txt
 *
 * 近似 controller 傳入值
 *
 * NOTE: 未找到 {custom*?} 的解決方案
 * dependency Illuminate\Console\Command
 */
trait ConsoleParameterized
{

    /**
     * @depends \Illuminate\Console\Command
     * @param string $parameterName
     * @return array
     * @throws Exception
     */
    protected function getAllParams(string $parameterName = 'custom'): array
    {
        static $params;
        if ($params) {
            return $params;
        }

        $arguments = $this->arguments() ?? [];
        if (!$arguments) {
            return [];
        }

        $params = $this->consoleParameterized_parse($parameterName, $arguments);
        return $params;
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * parser example
     *      account=111-222-3333
     *      ->
     *      ['account' => '111-222-3333']
     *
     * @param string $parameterName
     * @param array $arguments
     * @return array
     */
    protected function consoleParameterized_parse(string $parameterName, array $arguments): array
    {
        $originItems = $arguments[$parameterName] ?? [];
        $rows = [];
        foreach ($originItems as $text) {
            $data = explode('=', $text);
            if (isset($data[0]) && isset($data[1])) {
                $key = (string)$data[0];
                $rows[$key] = $data[1];
            }
        }

        return $this->consoleParameterized_stringValueConvert($rows);
    }

    /**
     * string value convert
     *
     * @param array $rows
     * @return array
     */
    protected function consoleParameterized_stringValueConvert(array $rows): array
    {
        foreach ($rows as $key => $value) {
            if ($value === 'null') {
                $value = null;
            } elseif ($value === 'true') {
                $value = true;
            } elseif ($value === 'false') {
                $value = false;
            } elseif (is_string($value) && mb_substr($value, 0, 1) === '[' && mb_substr($value, -1) === ']') {
                $value = substr($value, 1, -1);
                $data = explode(',', $value);
                $value = $data;
            }
            $rows[$key] = $value;
        }

        return $rows;
    }
}
