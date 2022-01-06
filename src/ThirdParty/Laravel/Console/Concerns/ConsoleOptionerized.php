<?php

declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Console\Concerns;

use Exception;

/**
 * Illuminate\Console\Command 提供了陣列化的輸入格式
 *
 *      $signature = 'prefix:command-name
 *          {--fromGoogleCustomerDashId=}
 *          {--expandType=}
 *          {--cpc=}
 *          {--options[expand_from]=}
 *          {--options[change_from]=}
 *          {--options[how_to_expand_campaign]=}
 *          {--options[use_local_phone_numbers]=}
 *      ';
 *
 * see ConsoleDashParameterized.txt
 * dependency Illuminate\Console\Command
 */
trait ConsoleOptionerized
{
    /**
     * @depends \Illuminate\Console\Command
     * @return array
     */
    protected function getCustomOptions(): array
    {
        static $params;
        if ($params) {
            return $params;
        }

        $options = $this->getIlluminateConsoleOptions() ?? [];
        if (!$options) {
            return [];
        }

        $params = $this->consoleParameterized_parse($options);
        return $params;
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * @param array $options
     * @return array
     */
    protected function consoleParameterized_parse(array $options): array
    {
        unset($options['help']);
        unset($options['quiet']);
        unset($options['verbose']);
        unset($options['version']);
        unset($options['ansi']);
        unset($options['no-ansi']);
        unset($options['no-interaction']);
        unset($options['env']);

        $options = $this->consoleDashParameterized_stringValueConvert($options);
        $options = $this->consoleDashParameterized_keyConvert($options);
        return $options;
    }

    /**
     * key convert
     *
     * @param array $rows
     * @return array
     */
    protected function consoleDashParameterized_keyConvert(array $rows): array
    {
        $options = [];
        foreach ($rows as $key => $value) {
            if (strpos($key, '[') && mb_substr($key, -1) === ']') {
                // one layer array
                $data = explode('[', mb_substr($key, 0, strlen($key) - 1));
                if (2 !== count($data)) {
                    continue;
                }
                $arrayName = (string)$data[0];
                $variableName = (string)$data[1];
                if (!isset($options[$arrayName])) {
                    $options[$arrayName] = [];
                }
                $options[$arrayName][$variableName] = $value;
            } else {
                $options[$key] = $value;
            }
        }
        return $options;
    }

    /**
     * string value convert
     *
     * @param array $rows
     * @return array
     */
    protected function consoleDashParameterized_stringValueConvert(array $rows): array
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

    protected function getIlluminateConsoleOptions(): array
    {
        return $this->options();
    }
}
