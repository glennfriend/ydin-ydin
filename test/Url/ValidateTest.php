<?php

use PHPUnit\Framework\TestCase;
use Cor\Ydin;

class Url_ValidateTest extends TestCase
{

    /**
     *  @dataProvider check_domain
     */
    public function test_domain($result, $url)
    {
        $this->assertEquals( $result, Ydin\Url\Validate::isDomain($url) );
    }

    public function check_domain()
    {
        return [
            [true,  'http://www.google.com'],
            [true,  'https://www.google.com'],
            [true,  'ftp://www.google.com'],

            [false, 'www.google.com'],
            [false, '//www.google.com'],
            [false, 'google.com'],
            [false, 'http://xxx'],
        ];
    }

}
