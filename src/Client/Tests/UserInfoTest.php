<?php

use PHPUnit\Framework\TestCase;

final class UserInfoTest extends TestCase
{
    /**
     * NOTE: 在 CLI 模式下, 無法取得 IP
     *
     * @test
     * @group client
     */
    public function getIp()
    {
        $ip = Ydin\Client\UserInfo::getIp();
        $this->assertEquals(true, null === $ip);
    }

}
