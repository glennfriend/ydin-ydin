<?php
declare(strict_types=1);

namespace Ydin\Name;

/**
 * name case converter
 *
 * @see https://github.com/jawira/case-converter
 * @version 0.1.0
 * @package Ydin\Name
 */
class NameCaseConverter
{
    /**
     * Hello World
     *
     * @param string $text
     * @return string
     */
    static function title(string $text): string
    {
        return (new Naming($text))->upperCamel(' ');
    }

    /**
     * hello world
     *
     * @param string $text
     * @return string
     */
    static function lower(string $text): string
    {
        return (new Naming($text))->lower(' ');
    }

    /**
     * TODO: 你得要想一個更好的命名
     *
     * helloworld
     *
     * @param string $text
     * @return string
     */
    static function lowerAndNoSymbol(string $text): string
    {
        return (new Naming($text))->lower();
    }

    /**
     * HelloWorld
     *
     * @param string $text
     * @return string
     */
    static function pascal(string $text): string
    {
        return (new Naming($text))->upperCamel();
    }

    /**
     * hello-world
     *
     * @param string $text
     * @return string
     */
    static function kebab(string $text): string
    {
        return (new Naming($text))->lower('-');
    }

    /**
     * hello_world
     *
     * @param string $text
     * @return string
     */
    static function snake(string $text): string
    {
        return (new Naming($text))->lower('_');
    }

    /**
     * HELLO_WORLD
     *
     * @param string $text
     * @return string
     */
    static function micro(string $text): string
    {
        return (new Naming($text))->upper('_');
    }


}
