<?php
declare(strict_types=1);

namespace Ydin\Name;

/**
 * Naming convention
 *
 * 分析整理程式碼字串的輔助工具
 * 參數的分離字元請使用 空白 or - or _ or 駝峰式字串
 * $nameObject = new Naming('books_admin');
 * $nameObject = new Naming('books admin');
 * $nameObject = new Naming('booksAdmin');
 *
 * $nameObject->lower();            = 'booksadmin';     // 全小寫             lowercase
 * $nameObject->lowerCamel();       = 'booksAdmin';     // 開頭小寫 駝峰式    camelCase
 * $nameObject->upperCamel();       = 'BooksAdmin';     // 開頭大寫           PascalCase
 * $nameObject->upper();            = 'BOOKSADMIN';     // 全大寫             UPPERCASE
 * $nameObject->lower('_');         = 'books_admin';    // 帶符號 全小寫      snake_case
 * $nameObject->upperCamel('_');    = 'Books_Admin';    // 帶符號 開頭大寫
 * $nameObject->upper('_');         = 'BOOKS_ADMIN';    // 帶符號 全大寫      SCREAMING_SNAKE_CASE
 * $nameObject->upper('-');         = 'BOOKS-ADMIN';    // 帶符號 全大寫      SCREAMING-KEBAB-CASE
 *
 * @version 0.1.0
 * @package Ydin\Name
 */
class Naming
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var string split sign
     */
    protected $sign = ' ';

    /**
     * support input format
     *      - space 空白 ' '
     *      - dash '-'
     *      - underline 下底線符號 '_'
     *      - camel case 駝峰式字串 'helloWorld'
     *
     * @param string $text , 分離字元參數 可以使用
     */
    public function __construct(string $text)
    {
        $text = str_replace('-', ' ', $text);
        $text = str_replace('_', ' ', $text);

        // 駝峰式分離: "aaaBbbCcc" => "aaa bbb ccc"
        $text = preg_replace("/(?<=\\w)(?=[A-Z])/", " $1", $text);

        $text = trim($text);
        $text = preg_replace('!\s+!', ' ', $text);

        // 字串最後將以 $this->sign 符號為分隔方式
        $text = str_replace(' ', $this->sign, $text);
        $this->text = strtolower($text);
    }

    /**
     * 小寫
     *
     * @param string $delimiter
     * @return string
     */
    public function lower(string $delimiter = ''): string
    {
        return str_replace($this->sign, $delimiter, $this->text);
    }

    /**
     * 大寫
     *
     * @param string $delimiter
     * @return string
     */
    public function upper($delimiter = ''): string
    {
        return str_replace($this->sign, $delimiter, strtoupper($this->text));
    }

    /**
     * 駝峰式 開頭小寫
     *
     * @param string $delimiter
     * @return string
     */
    public function lowerCamel(string $delimiter = ''): string
    {
        $string = str_replace($this->sign, $delimiter, ucwords($this->text, $this->sign));
        return lcfirst($string);
    }

    /**
     * 駝峰式 開頭大寫
     *
     * @param string $delimiter
     * @return string
     */
    public function upperCamel(string $delimiter = ''): string
    {
        $string = str_replace($this->sign, $delimiter, ucwords($this->text, $this->sign));
        return ucfirst($string);
    }

}
