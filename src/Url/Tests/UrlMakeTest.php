<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Ydin\Url\UrlMake;

final class UrlMakeTest extends TestCase
{
    /**
     * @test
     */
    public function url_make_parse()
    {
        $url = 'https://example.com/1/Hi - Ext.jpg?&data=100&age=20';
        $urlInfo = <<<EOD
{
    "scheme": "https",
    "host": "example.com",
    "path": "/1/Hi - Ext.jpg",
    "query": "&data=100&age=20",
    "queryInfo": {
        "data": "100",
        "age": "20"
    },
    "pathInfo": {
        "dirname": "/1",
        "basename": "Hi - Ext.jpg",
        "extension": "jpg",
        "filename": "Hi - Ext"
    }
}
EOD;
        $this->assertEquals($urlInfo, json_encode(UrlMake::parse($url), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * @test
     */
    public function url_make_build()
    {
        $url = 'https://example.com/hi/hello-world?data=100&age=20';
        $urlInfo = <<<EOD
{
    "scheme": "https",
    "host": "example.com",
    "path": "/hi/hello-world",
    "query": "data=100&age=20",
    "queryInfo": {
        "data": "100",
        "age": "20"
    },
    "pathInfo": {
        "dirname": "/hi",
        "basename": "hello-world",
        "filename": "hello-world",
        "extension": ""
    }
}
EOD;
        $this->assertEquals($url, UrlMake::build(json_decode($urlInfo, true)));
    }

    /**
     * @test
     */
    public function url_convert_brackets()
    {
        $url = 'https://example.com/?data=%28%29_%5B%5D_%7B%7D';
        $res = 'https://example.com/?data=()_[]_{}';
        $this->assertEquals($res, UrlMake::convertBrackets($url));
    }

    /**
     * @test
     */
    public function url_convert_space()
    {
        $url = 'https://example.com/?data=aa%20bb';
        $res = 'https://example.com/?data=aa+bb';
        $this->assertEquals($res, UrlMake::build(UrlMake::parse($url)));
    }

}
