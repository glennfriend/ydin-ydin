<?php

use PHPUnit\Framework\TestCase;
use Ydin\Replace\PhoneNumberReplace;

final class PhoneNumberReplaceTest extends TestCase
{
    /**
     * @test
     */
    public function not_change_anything_PhoneNumberReplace()
    {
        $url = 'https://example.com/?&my_state={ca}&my_city=los-angeles&myName=rent+homes&onr_call=2225550123&mytag=1112223333';
        $res = $url;
        $this->assertEquals($res, PhoneNumberReplace::replacePhoneNumber($url));
    }

    /**
     * @test
     */
    public function phone_format_PhoneNumberReplace()
    {
        $url = 'https://example.com/?onr_call=222-555-0123&mytag=111-222-3333';
        $res = 'https://example.com/?onr_call=2225550123&mytag=1112223333';
        $this->assertEquals($res, PhoneNumberReplace::replacePhoneNumber($url));

        //
        $url = 'https://example.com/?onr_call=(222)%20555-0123&mytag=(111)%20222-3333';
        $res = 'https://example.com/?onr_call=2225550123&mytag=1112223333';
        $this->assertEquals($res, PhoneNumberReplace::replacePhoneNumber($url));
    }

}
