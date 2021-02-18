
Csv
```php
use Ydin\ThirdParty\LeagueCsv\CsvReader;

    $filterHook = function (array $row) {
        foreach ($row as $key => $value) {
            if ('bool' === $key) {
                $row[$key] = (bool)$value;
            }
            if (in_array($key, ['age', 'lat', 'lng'])) {
                $row[$key] = (double)$value;
            }
            if ('url' === $key) {
                if (false !== stristr($value, 'https://')) {
                    $row['is_ssh'] = true;
                } else {
                    $row['is_ssh'] = false;
                }
            }
        }
        return $row;
    };

    //
    $csvFile = '1.csv';
    $csv = new CsvReader($csvFile);
    $csv->addHook($filterHook);

    // get yield
    foreach ($csv->each() as $row) {
        dump($row);
        exit;
    }
```

