<?php
use PHPUnit\Framework\TestCase;

final class JsonParseTest extends TestCase
{
    /**
     *
     */
    public function test_json_parse()
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
