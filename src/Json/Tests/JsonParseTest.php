<?php

use PHPUnit\Framework\TestCase;

final class JsonParseTest extends TestCase
{
    /**
     * @test
     * @group json
     */
    public function json_parse()
    {
        $text = <<<EOD
{
    "name": "alice",
    "age": 18,
    "friends": {
        "22": {
            "id": "22",
            "name": "bob"
        },
        "44": {
            "id": "44",
            "name": "vivian"
        }
    }
}
EOD;

        $json = Ydin\Json\Parse::parse($text);
        $this->assertEquals('vivian', $json['friends']['44']['name']);
    }

}
