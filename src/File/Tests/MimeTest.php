<?php

use PHPUnit\Framework\TestCase;

class File_MimeTest extends TestCase
{
    /**
     * @test
     * @group file
     */
    public function getByFile()
    {
        $fileMime = Ydin\File\Mime::getByFile(__FILE__);
        $this->assertEquals(true, 'text/x-php' === $fileMime);
    }

    /**
     * @test
     * @group file
     */
    public function getExtendGroup()
    {
        $extendGroup = Ydin\File\Mime::getExtendGroup();
        $this->assertEquals( true, isset($extendGroup['csv']));
        $this->assertEquals( true, isset($extendGroup['jpg']));
        $this->assertEquals( true, isset($extendGroup['gif']));
        $this->assertEquals( true, isset($extendGroup['png']));
    }

    /**
     * @test
     * @group file
     */
    public function getByExtendName()
    {
        $mimeList = Ydin\File\Mime::getByExtendName('csv');
        $this->assertEquals(
            true,
            in_array('application/csv-tab-delimited-table',$mimeList),
            '找不到 "csv" 對應的 mime type "application/csv-tab-delimited-table"'
        );
    }

}
