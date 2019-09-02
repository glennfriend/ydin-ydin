<?php
namespace Cor\Ydin\Url;

/**
 * Url Vlidate
 *
 * @version 0.1.0
 * @package Cor\Ydin\Url\Validate
 */
class Validate
{

    /**
     *  is domain
     *
     *  @return boolean
     */
    public static function isDomain($url)
    {
        return (bool) preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url);
    }

    /**
     *  internet file exists
     *
     *  @codeCoverageIgnore
     *      略過測試的原因: 會花較久的時間測試, 等待
     *
     *  @see curl_init
     *  @return boolean
     */
    /*
    public static function isExist($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$code) {
            return false;
        }
        if (!in_array($code, [200,301,302])) {
           return false;
        }
        return true;
    }
    */

}
