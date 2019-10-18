<?php

use PHPUnit\Framework\TestCase;

class Html_FilterTest extends TestCase
{

    /**
     *  @dataProvider check_htmlTags
     */
    public function test_htmlTags($result, $html)
    {
        // echo $html . ' = ';
        // echo Ydin\Html\Filter::htmlTags($html);
        // echo "\n";
        $this->assertEquals( $result, $html === Ydin\Html\Filter::htmlTags($html));
    }

    public function check_htmlTags()
    {
        return [
            [true,  'abc'],

            [false, '123<br>'],
            [false, '123<br/>'],
            [false, '<p>123</p>'],
            [false, '<b>123</b>'],
            [false, '<html>123</html>'],
            [false, '<head>123</head>'],
            [false, '<body>123</body>'],
        ];
    }




    /**
     *  @dataProvider check_javascriptTags
     */
    public function test_javascriptTags($result, $html)
    {
        // echo $html . ' = ';
        // echo Ydin\Html\Filter::javascriptTags($html);
        // echo "\n";
        $this->assertEquals( $result, $html === Ydin\Html\Filter::javascriptTags($html));
    }

    public function check_javascriptTags()
    {
        return [
            [true,  '111'],
            [false, '<script>111</script>'],
            [false, '<script src="XSS">111</script>'],

            [true,  '<a href="#">222</a>'],
            [false, '<a href="#" onclick="KeyUp()">222</a>'],

            [true,  '<b>333</b>'],
            [false, '<b onClick="hack()">333</b>'],
            [false, '<b onClick="hack">333</b>'],
            [false, '<b onClick="">333</b>'],
        ];
    }
}
