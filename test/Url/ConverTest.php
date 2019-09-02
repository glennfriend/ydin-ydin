<?php

use PHPUnit\Framework\TestCase;
use Cor\Ydin;

class Url_ConverTest extends TestCase
{

    /**
     *  @dataProvider check_mailto
     */
    public function test_mailto($result, $url)
    {
        // echo Ydin\Url\Convert::mailto($url);
        // echo "\n";
        $this->assertEquals( $result, $url !== Ydin\Url\Convert::mailto($url));
    }

    public function check_mailto()
    {
        return [
            [true,  'ken@hotmail.com'],
            [true,  'ken.huan@hotmail.com'],
            [true,  'ken-huan@hotmail.com'],
            [true,  'ken_huan@hotmail.com'],

            [false, 'KEN@hotmail.com'],
            [false, 'ken＠hotmail.com'],
            [false, 'ken!hotmail.com'],
            [false, 'ken@@hotmail.com'],
        ];
    }




    /**
     *  @dataProvider check_link
     */
    public function test_link($result, $url)
    {
        // echo Ydin\Url\Convert::link($url);
        // echo "\n";
        $this->assertEquals( $result, $url !== Ydin\Url\Convert::link($url));
    }

    public function check_link()
    {
        return [
            [true,  'http://www.google.com'],
            [true,  'https://www.google.com'],

            [false, 'ftp://www.google.com'],
            [false, 'www.google.com'],
            [false, 'google.com'],

            //[true,  '//www.google.com'],
        ];
    }

}
