<?php
namespace Cor\Ydin\String;

/**
 * String
 *
 * @version 1.0.0
 * @package Cor\Ydin\String\Convert
 */
class Convert
{

    /**
     * 去除不必要的符號
     * 留下易讀的文字字串
     *
     * e.g.
     *      "Current Date"  => "current_date"
     *      "Current-Date"  => "current_date"
     *      "___a___b___"   => "a_b"
     *      " # HTML 標題:" => "html"
     *
     */
    public static function slug($value, $char='_')
    {
        $value = str_replace(['-', ' ', '&', '|'], '_', $value);
        $value = preg_replace("/[^a-zA-Z0-9_]+/", '', $value);
        $value = preg_replace('/_+/', $char, $value);

        // last modify
        $value = trim($value, $char);
        $value = strtolower(trim($value));
        return $value;
    }

}
