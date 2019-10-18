<?php

use PHPUnit\Framework\TestCase;

final class DotTest extends TestCase
{
    protected $items = [
        'name'      => 'ken',
        'age'       => 18,
        'job'       => 'student',
        'interest'  => ['football', 'baseball', 'movie'],
        'report'    => [
            'math'      => 100,
            'english'   => 90,
            'chemical'  => 20,
        ],
    ];

    /**
     * @testdox Get dot by array
     * @test
     * @group array-kit
     */
    public function factory_dot()
    {
        $dot = Ydin\ArrayKit\Dot::factory($this->items);

        // basic
        $this->assertEquals( true,  $this->items['name']            === $dot('name')        );
        $this->assertEquals( true,  $this->items['interest'][0]     === $dot('interest.0')  );
        $this->assertEquals( true,  $this->items['interest'][1]     === $dot('interest.1')  );
        $this->assertEquals( true,  $this->items['report']['math']  === $dot('report.math') );

        // default value
        $this->assertEquals( true,  null === $dot('nothing')        );
        $this->assertEquals( true,  'hi' === $dot('nothing', 'hi')  );

        // value type
        $this->assertEquals( true,  $dot('age')  === 18 );
        $this->assertEquals( false, $dot('age')  === '18' );
    }

}
