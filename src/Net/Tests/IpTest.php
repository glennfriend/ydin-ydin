<?php

use PHPUnit\Framework\TestCase;
use Cor\Ydin;

class Net_IpTest extends TestCase
{
    /**
     *  
     */
    public function test_isPrivate()
    {
        $this->assertEquals( true, Ydin\Net\Ip::isPrivate('127.0.0.1')   );
        $this->assertEquals( true, Ydin\Net\Ip::isPrivate('10.0.0.0')    );
        $this->assertEquals( true, Ydin\Net\Ip::isPrivate('172.16.0.0')  );
        $this->assertEquals( true, Ydin\Net\Ip::isPrivate('192.168.0.0') );
        
        $this->assertEquals( false, Ydin\Net\Ip::isPrivate('8.8.8.8')   );
        $this->assertEquals( false, Ydin\Net\Ip::isPrivate('')          );
        $this->assertEquals( false, Ydin\Net\Ip::isPrivate(null)        );
        $this->assertEquals( false, Ydin\Net\Ip::isPrivate(false)       );
    }

    /**
     *  @dataProvider check_ip2ong
     */
    public function test_ip2ong($value, $reault)
    {
        $this->assertEquals( Ydin\Net\Ip::ip2long($value), $reault);
    }
    /**
     *
     */
    public function check_ip2ong()
    {
        return [
            ['127.0.0.1',       2130706433],
            ['10.0.0.0',        167772160],
            ['172.16.0.0',      2886729728],
            ['192.168.0.0',     3232235520],
            ['192.168.0.1',     3232235521],
            ['0.0.0.0',         0],
            ['0.0.0.1',         1],
            ['255.255.255.255', 4294967295],

            [null,              0],
            [false,             0],
            ['0',               0],
            ['-1',              0],
            ['255.255.255.256', 0],
        ];
    }

}
