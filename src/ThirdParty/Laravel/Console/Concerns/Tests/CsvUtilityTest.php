<?php

namespace Ydin\ThirdParty\Laravel\Console\Concerns\Test;

use Tests\TestCase;
use Ydin\ThirdParty\Laravel\Console\Concerns\CsvUtility;

class CsvUtilityTest extends TestCase
{
    use CsvUtility;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function headers()
    {
        $headers = $this->getCsvHeaders();
        $this->assertEquals(['id', 'name', 'age'], $headers);
    }

    /**
     * @test
     */
    public function importFile()
    {
        // $this->csvConfirm();

        $generator = $this->generatorCsvContent();

        $row = $generator->current();
        $this->assertEquals($row['id'], 1);
        $this->assertEquals($row['name'], 'Alice');
        $this->assertEquals($row['age'], '20');

        $generator->next();
        $row = $generator->current();
        $this->assertEquals($row['id'], 3);
        $this->assertEquals($row['name'], 'Coco');
        $this->assertEquals($row['age'], '40');

        $generator->next();
        $row = $generator->current();
        $this->assertNull($row);
    }

    /**
     * @test
     */
    public function hook()
    {
        $Generator = $this->generatorCsvContent();
        $row = $Generator->current();

        $this->assertEquals($row['custom_combination'], '1_Alice');
    }


    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

    // Illuminate\Console\Command
    protected function confirm(): bool
    {
        return true;
    }

    // CsvUtility overwrite method
    protected function csvConfig(): array
    {
        return [
            'csvFile' => __DIR__ . '/tests.csv',
        ];
    }

    // CsvUtility overwrite method
    protected function csvRowHook(array $row): array
    {
        $row['custom_combination'] = $row['id'] . '_' . $row['name'];
        return $row;
    }

}
