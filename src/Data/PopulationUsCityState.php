<?php
declare(strict_types=1);

namespace Ydin\Data;

/**
 * 201x 年每個 state 下最多人口的 city
 *
 * @package Ydin\Data
 */
class PopulationUsCityState
{

    /**
     * @param string $state
     * @return array|null
     */
    public static function getByState(string $state)
    {
        $rows = array_column(static::getAll(), 'stateCode');
        $index = array_search($state, $rows);
        if (false === $index) {
            return null;
        }

        return static::getByIndex($index);
    }

    /**
     * @param int $index
     * @return array|null
     */
    public static function getByIndex(int $index): array
    {
        $data = static::getAll();
        if (!isset($data[$index])) {
            return null;
        }

        return $data[$index];
    }

    /**
     * City Name & State Code
     *
     * @return array
     */
    public static function getAll(): array
    {
        return array_map(function ($row) {
            return array_combine(['cityName', 'stateCode'], $row);
        }, static::getOriginData());
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

    /**
     * @return array
     */
    private static function getOriginData(): array
    {
        return [
            ['Houston', 'TX'],
            ['Chicago', 'IL'],
            ['Brooklyn', 'NY'],
            ['Los Angeles', 'CA'],
            ['Miami', 'FL'],
            ['Philadelphia', 'PA'],
            ['Las Vegas', 'NV'],
            ['Phoenix', 'AZ'],
            ['Minneapolis', 'MN'],
            ['Denver', 'CO'],
            ['Atlanta', 'GA'],
            ['Indianapolis', 'IN'],
            ['Seattle', 'WA'],
            ['Saint Louis', 'MO'],
            ['Portland', 'OR'],
            ['Charlotte', 'NC'],
            ['Columbus', 'OH'],
            ['Milwaukee', 'WI'],
            ['Louisville', 'KY'],
            ['Memphis', 'TN'],
            ['Oklahoma City', 'OK'],
            ['Washington', 'DC'],
            ['Albuquerque', 'NM'],
            ['Detroit', 'MI'],
            ['Baltimore', 'MD'],
            ['Salt Lake City', 'UT'],
            ['Omaha', 'NE'],
            ['Birmingham', 'AL'],
            ['Virginia Beach', 'VA'],
            ['New Orleans', 'LA'],
            ['Wichita', 'KS'],
            ['Honolulu', 'HI'],
            ['Columbia', 'SC'],
            ['Newark', 'NJ'],
            ['Boise', 'ID'],
            ['Anchorage', 'AK'],
            ['Boston', 'MA'],
            ['Des Moines', 'IA'],
            ['Wilmington', 'DE'],
            ['Little Rock', 'AR'],
            ['Providence', 'RI'],
            ['Sioux Falls', 'SD'],
            ['Jackson', 'MS'],
            ['Bridgeport', 'CT'],
            ['Billings', 'MT'],
            ['Fargo', 'ND'],
            ['Charleston', 'WV'],
            ['Manchester', 'NH'],
            ['Cheyenne', 'WY'],
            ['Portland', 'ME'],
            ['Burlington', 'VT'],
        ];
    }

}
