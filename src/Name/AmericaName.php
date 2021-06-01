<?php
declare(strict_types=1);

namespace Ydin\Name;

/**
 * first name
 *      - 是美國人的 名
 *      - 跟名有關的資料比較少, 通常只有 姓別
 * last name
 *      - 是美國人的 姓
 *      - 大部份的統計資料都來自於 姓
 *
 * @version 0.1.0
 * @package Ydin\Name
 */
class AmericaName
{

    /**
     * NOTE: Chris 建議先用簡單的方式, 之後有需要再加強
     *
     * @param string $originLastName
     * @return string
     */
    public static function lastNameCase(string $originLastName): string
    {
        $allWords = explode('-', $originLastName);
        foreach ($allWords as $index => $word) {
            $allWords[$index] = ucwords(strtolower($word));
        }
        $lastName = join('-', $allWords);

        /**
         * Mc 開頭的姓
         */
        if ('mc' === strtolower(substr($lastName, 0, 2))) {
            $lastName[0] = 'M';
            $lastName[1] = 'c';
            $lastName[2] = strtoupper(substr($lastName, 2, 1));
        }
        /**
         * Di*
         */
        if ('di' === strtolower(substr($lastName, 0, 2))) {
            $lastName[0] = 'D';
            $lastName[1] = 'i';
            $lastName[2] = strtoupper(substr($lastName, 2, 1));
        }
        /**
         * O'*
         */
        if ("o'" === strtolower(substr($lastName, 0, 2))) {
            $lastName[0] = 'O';
            $lastName[1] = "'";
            $lastName[2] = strtoupper(substr($lastName, 2, 1));
        }

        return $lastName;
    }

    /**
     * @param string $name
     * @return string
     * @see 嗚謝EricChang
     * @see https://www.media-division.com/correct-name-capitalization-in-php/
     */
    public static function titleCase(string $name): string
    {
        $word_splitters = [' ', '-', "O'", "L'", "D'", 'St.', 'Mc', 'Di'];
        $lowercase_exceptions = ['the', 'van', 'den', 'von', 'und', 'der', 'de', 'da', 'of', 'and', "l'", "d'"];
        $uppercase_exceptions = ['III', 'IV', 'VI', 'VII', 'VIII', 'IX'];

        $name = strtolower($name);
        foreach ($word_splitters as $delimiter) {
            $words = explode($delimiter, $name);
            $newWords = [];
            foreach ($words as $word) {
                if (in_array(strtoupper($word), $uppercase_exceptions)) {
                    $word = strtoupper($word);
                } else {
                    if (!in_array($word, $lowercase_exceptions)) {
                        $word = ucfirst($word);
                    }
                }
                $newWords[] = $word;
            }

            if (in_array(strtolower($delimiter), $lowercase_exceptions))
                $delimiter = strtolower($delimiter);

            $name = join($delimiter, $newWords);
        }
        return $name;
    }

}
