<?php
declare(strict_types=1);

namespace Ydin\Url;

/**
 * Class UrlMake
 *
 * @version 0.1.0
 * @package Ydin\Url
 */
class UrlMake
{
    /**
     * @param string $url
     * @return array|null
     */
    public static function parse(string $url): ?array
    {
        $urlInfo = parse_url($url);
        $urlInfo += [
            'scheme'    => 'https',
            'host'      => '',
            'path'      => '',
            'query'     => '',
            'queryInfo' => [],
        ];

        parse_str($urlInfo['query'], $urlInfo['queryInfo']);
        $urlInfo['pathInfo'] = pathinfo($urlInfo['path']);
        $urlInfo['pathInfo'] += [
            "dirname"   => '',
            "basename"  => '',
            "extension" => '',
            "filename"  => '',
        ];

        return $urlInfo;
    }

    /**
     * @param array $urlInfo
     * @return string|null
     */
    public static function build(array $urlInfo): ?string
    {
        $url = "{$urlInfo['scheme']}://{$urlInfo['host']}{$urlInfo['path']}";
        if ($urlInfo['queryInfo']) {
            $url .= '?' . http_build_query($urlInfo['queryInfo'], '', '&', PHP_QUERY_RFC3986);
        }

        return $url;
    }

    /**
     * http_build_query() 會轉換所有標準的 url 符號
     * 這裡是做一些符號的轉換, 將一些編碼還原
     * 例如以下的符號
     *      () [] {}
     *
     * @param string $url
     * @return string
     */
    public static function convertBrackets(string $url): string
    {
        $url = static::replaceBraces($url);
        $url = static::replaceBrackets($url);
        $url = static::replaceParenthesis($url);
        return $url;
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * {}
     */
    private static function replaceBraces(string $url): string
    {
        $url = str_replace('%7B', '{', $url);
        $url = str_replace('%7D', '}', $url);
        return $url;
    }

    /**
     * []
     */
    private static function replaceBrackets(string $url): string
    {
        $url = str_replace('%5B', '[', $url);
        $url = str_replace('%5D', ']', $url);
        return $url;
    }

    /**
     * ()
     */
    private static function replaceParenthesis(string $url): string
    {
        $url = str_replace('%28', '(', $url);
        $url = str_replace('%29', ')', $url);
        return $url;
    }

}
