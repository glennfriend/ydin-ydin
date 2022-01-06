<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Console\Concerns;

use Exception;
use Generator;
use League\Csv\AbstractCsv;
use League\Csv\Exception as CsvException;
use League\Csv\Reader;
use Ydin\Csv\Convert as CsvConvert;

/**
 * dependency Illuminate\Console\Command
 * dependency composer League\Csv
 */
trait CsvUtility
{

    /**
     * @param string $key
     * @return mixed|null
     * @throws Exception
     */
    protected function getCsvConfig(string $key)
    {
        $config = $this->csvConfig();

        if (!isset($config['csvFile']) || !$config['csvFile']) {
            throw new Exception('csvConfig() -> csvFile ont found');
        }

        return $config[$key] ?? null;
    }

    /**
     * NOTE: 該程式會將 string("NULL") convert to boolean(null)
     *
     * @return Generator
     * @throws CsvException
     */
    protected function generatorCsvContent(): Generator
    {
        $csv = $this->_getCsvReader();
        $headers = $this->getCsvHeaders();

        foreach ($csv->getRecords() as $row) {
            // dump($row);
            $row = array_combine($headers, $row);

            // NOTE: custom convert
            array_walk($row, function (&$value, $key) {
                if ("NULL" === $value) {
                    $value = null;
                }
            });

            yield $this->csvRowHook($row);
        }

        return;
    }

    /**
     * @throws Exception
     */
    protected function csvConfirm()
    {
        $this->_csvValidate();
        $csvFile = $this->getCsvConfig('csvFile');
        if (!$this->confirm("Import file: `{$csvFile}` ?")) {
            exit;
        }
    }

    // --------------------------------------------------------------------------------
    //  overwrite methods
    // --------------------------------------------------------------------------------

    /**
     * NOTE: you can overwrite it
     *
     * @return array
     */
    protected function csvConfig(): array
    {
        /*
        $config = [
            'csvFile' => storage_path('import-2021-07-06.csv'),
        ];
        */
        return [];
    }

    /**
     * NOTE: you can overwrite it
     *
     * @param array $row
     * @return array
     */
    protected function csvRowHook(array $row): array
    {
        /*
        $row['master_key'] = $row['name'];

        // NOTE: custom convert
        array_walk($row, function (&$value, $key) {

            if ("gender" === $key) {
                if ("1" === $value) {
                    $value = "male";
                } elseif ("0" === $value) {
                    $value = "male";
                } else {
                    $value = "other";
                }
            }

            if (in_array($key, ['price', 'money', 'twd', usd', ])) {
                // $1,230 to 1230
                $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            }

        });
        */
        return $row;
    }

    /**
     * NOTE: you can overwrite it
     *
     * @return array
     * @throws CsvException
     */
    protected function getCsvHeaders(): array
    {
        // return ['id', 'name', 'attribute', 'value'];

        $csv = $this->_getCsvReader();
        return CsvConvert::headerConvert($csv->getHeader());
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * @throws Exception
     */
    protected function _csvValidate()
    {
        $csvFile = $this->getCsvConfig('csvFile');
        if (!file_exists($csvFile)) {
            throw new Exception("import CSV file not found");
        }

        $mimeType = mime_content_type($csvFile);
        switch ($mimeType) {
            case 'text/plain':
                // safe
                break;
            default:
                throw new Exception("csv file MIME type error");
        }
    }

    /**
     * @return AbstractCsv|Reader
     * @throws CsvException
     */
    protected function _getCsvReader(): AbstractCsv
    {
        $csvFile = $this->getCsvConfig('csvFile');
        $csv = Reader::createFromPath($csvFile);
        $csv->setHeaderOffset(0);

        return $csv;
    }

}

/*

$this->csvConfirm();

// 直接使用
// foreach($this->generatorCsvContent() as $row) {}

// 整理後使用
$keyRows = [];
foreach ($this->generatorCsvContent() as $row) {
    dd($row);
    $key = $row['zip_code'];
    $keyRows[$key] = $row;
}

// add csvConfig()
// add csvRowHook()

*/
