<?php
declare(strict_types=1);

namespace Ydin\Data;

/**
 * 201x 年 city, state 的人口數量與排序
 *
 * @package Ydin\Data
 */
class PopulationUsCity
{

    /**
     * @param string $city
     * @param string $state
     * @return array|null
     */
    public static function getByCityAndState(string $city, string $state): ?array
    {
        foreach (static::getOriginData() as $index => $row) {
            if (strtolower($row['city']) === strtolower($city)
                && $row['stateCode'] === strtoupper($state)) {
                return static::getByIndex($index);
            }
        }

        return null;
    }

    /**
     * @param int $orderId
     * @return array|null
     */
    public static function getByOrderId(int $orderId): ?array
    {
        $rows = array_column(static::getAll(), 'orderId');
        $index = array_search($orderId, $rows);
        if (false === $index) {
            return null;
        }

        return static::getByIndex($index);
    }

    /**
     * City Name & State Code
     *
     * @return array
     */
    public static function getAll(): array
    {
        return array_map(function ($row) {
            return [
                'city'      => $row['city'],
                'stateCode' => $row['stateCode'],
                'orderId'   => $row['orderId'],
            ];
        }, static::getOriginData());
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

    /**
     * @param int $index
     * @return array|null
     */
    private static function getByIndex(int $index): ?array
    {
        $data = static::getOriginData();
        if (!isset($data[$index])) {
            return null;
        }

        return $data[$index];
    }

    /**
     * @return array
     */
    private static function getOriginData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/PopulationUsCity.json'), true);
    }

}
