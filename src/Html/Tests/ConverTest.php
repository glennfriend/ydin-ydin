<?php

use PHPUnit\Framework\TestCase;

class Html_ConverTest extends TestCase
{

    /**
     *  @dataProvider check_unicode2Text
     */
    public function test_unicode2Text($code, $text)
    {
        // echo $text . ' = ';
        // echo Ydin\Html\Convert::unicode2Text($code);
        // echo "\n";
        $this->assertEquals( $text, Ydin\Html\Convert::unicode2Text($code));
    }

    public function check_unicode2Text()
    {
        return [
            ['&#36935;',            '遇'    ],
            ['&#21040;',            '到'    ],
            ['&#36935;&#21040;',    '遇到'  ],
            ['&#21335;&#21435;&#32147;&#19977;&#22283;&#65292;&#26481;&#20358;&#36942;&#20116;&#28246;', '南去經三國，東來過五湖'],
        ];
    }




    /**
     *  @dataProvider check_text2Unicode
     */
    public function test_text2Unicode($text, $code)
    {
        // echo $code . ' = ';
        // echo Ydin\Html\Convert::text2Unicode($text);
        // echo "\n";
        $this->assertEquals( $code, Ydin\Html\Convert::text2Unicode($text));
    }

    public function check_text2Unicode()
    {
        return [
            ['☆',      '&#9734;'],
            ['★',      '&#9733;'],
            ['○',      '&#9675;'],
            ['南去經三國，東來過五湖',  '&#21335;&#21435;&#32147;&#19977;&#22283;&#65292;&#26481;&#20358;&#36942;&#20116;&#28246;'],
            ['さたけ　よしのぶ',        '&#12373;&#12383;&#12369;&#12288;&#12424;&#12375;&#12398;&#12406;'],
            ['犇驫鄜磡栞𧒽雫潟',        '&#29319;&#39531;&#37148;&#30945;&#26654;&#160957;&#38635;&#28511;'],
        ];
    }

}
