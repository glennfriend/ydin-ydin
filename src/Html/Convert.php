<?php
declare(strict_types=1);
namespace Ydin\Html;

/**
 * Html Convert
 *
 * @version 1.0.0
 * @package Ydin\Html\Convert
 */
class Convert
{
    /**
     *  htmlString The original string with html entities encoded
     *  將已經被編碼過的 unicode 解碼為正常文字碼
     *  
     *  使用時機:
     *      一段被編碼過的內容, 無法被搜尋
     *      如果希望內容被搜尋, 請解碼後存在某個 "專門用於搜尋的欄位"
     *
     *  example:
     *      "&#36935; &#21040;" to "遇 到"
     *
     *  @param unicode string
     *  @return text string
     */
    public static function unicode2Text($unicode)
    {
        return preg_replace_callback(
            '~(&#[0-9a-f]+;)~i',
            function ($matches) {
                return mb_convert_encoding($matches[0], 'UTF-8', 'HTML-ENTITIES');
            },
            $unicode
        );
    }

    /**
     *  將文字轉為 unicode
     */
    public static function text2Unicode($text)
    {
        return mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8');
    }

}
