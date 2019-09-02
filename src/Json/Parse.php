<?php
declare(strict_types = 1);
namespace Ydin\Json;

use Exception;

/**
 * Class Parse
 *
 * @version 0.1.0
 * @package Ydin\Json
 */
class Parse
{

    /**
     * parse by string
     *
     * @param $text
     * @return mixed
     */
    public static function parse($text)
    {
        $json = json_decode($text, true);

        $errorCode = json_last_error();
        if (JSON_ERROR_NONE === $errorCode) {
            return $json;
        }

        $message = 'error';
        switch ($errorCode) {
            case JSON_ERROR_DEPTH:                  $message = 'JSON_ERROR_DEPTH';                  break;
            case JSON_ERROR_STATE_MISMATCH:         $message = 'JSON_ERROR_STATE_MISMATCH';         break;
            case JSON_ERROR_CTRL_CHAR:              $message = 'JSON_ERROR_CTRL_CHAR';              break;
            case JSON_ERROR_SYNTAX:                 $message = 'JSON_ERROR_SYNTAX';                 break;
            case JSON_ERROR_UTF8:                   $message = 'JSON_ERROR_UTF8';                   break;
            case JSON_ERROR_RECURSION:              $message = 'JSON_ERROR_RECURSION';              break;
            case JSON_ERROR_INF_OR_NAN:             $message = 'JSON_ERROR_INF_OR_NAN';             break;
            case JSON_ERROR_UNSUPPORTED_TYPE:       $message = 'JSON_ERROR_UNSUPPORTED_TYPE';       break;
            case JSON_ERROR_INVALID_PROPERTY_NAME:  $message = 'JSON_ERROR_INVALID_PROPERTY_NAME';  break;
            case JSON_ERROR_UTF16:                  $message = 'JSON_ERROR_UTF16';                  break;
        }

        throw new Exception($message, $errorCode);
    }

    /**
     * parse by file
     *
     * @param $pathFile
     * @return mixed|null
     */
    public static function parseFile($pathFile)
    {
        if (! file_exists($pathFile)) {
            return null;
        }

        $text = file_get_contents($pathFile);
        return static::parse($text);
    }

}
