<?php

use PHPUnit\Framework\TestCase;
use Ydin\ThirdParty\LeagueCsv\CsvReader;

final class CsvReaderTest extends TestCase
{
    /**
     *
     */
    public function test_csvLoad()
    {
        $file = __DIR__ . '/' . '1.csv';
        $csv = new CsvReader($file);

        $rows = [];
        foreach ($csv->each() as $row) {
            $rows[] = $row;
        }

        // dump($rows[0]);
        $this->assertEquals(5, count($rows));
        $this->assertEquals("77449", $rows[0]['zip']);
        $this->assertEquals("29.83556", $rows[0]['lat']);
        $this->assertEquals("-95.73813", $rows[0]['lng']);
        $this->assertEquals("Katy", $rows[0]['city']);
        $this->assertEquals("TRUE", $rows[0]['bool']);
        $this->assertTrue(key_exists('population', $rows[0]));
        $this->assertTrue(key_exists('population_duplicated_2', $rows[0]));
        $this->assertTrue(key_exists('population_duplicated_3', $rows[0]));
        $this->assertFalse(key_exists('population_duplicated_4', $rows[0]));
    }

    /**
     *
     */
    public function test_csvReaderAddHook()
    {
        $filterHook = function (array $row) {
            foreach ($row as $key => $value) {
                if ('bool' === $key) {
                    $row[$key] = (bool)$value;
                }
            }
            return $row;
        };

        $file = __DIR__ . '/' . '1.csv';
        // $file = base_path('1.csv');
        $csv = new CsvReader($file);
        $csv->addHook($filterHook);

        $rows = [];
        foreach ($csv->each() as $row) {
            $rows[] = $row;
        }

        $this->assertEquals(true, $rows[0]['bool']);
    }

}