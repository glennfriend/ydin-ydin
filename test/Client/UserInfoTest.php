<?php
use PHPUnit\Framework\TestCase;

final class UserInfoTest extends TestCase
{
    /**
     *  在 CLI 模式下, 無法取得 IP
     */
    public function test_getIp()
    {
        $ip = Ydin\Client\UserInfo::getIp();
        $this->assertEquals(true, null === $ip);
    }

}
