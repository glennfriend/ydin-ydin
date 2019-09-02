<?php
namespace Cor\Ydin\Url;

/**
 * Url Convert
 *
 * @version 1.0.0
 * @package Cor\Ydin\Url\Convert
 */
class Convert
{

    /**
     *  text to HTML mailto
     */
    public static function mailto($text)
    {
        return preg_replace('/(([a-z0-9+_-]+)(.[a-z0-9+_-]+)*@([a-z0-9-]+.)+[a-z]{2,6})/', '<a href="mailto:$1">$1</a>', $text);
    }

    /**
     *  text to HTML link
     */
    public static function link($text)
    {
        $regex = '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@';
        return preg_replace( $regex, '<a href="$1" target="_blank">$1</a>', $text );
    }

}
