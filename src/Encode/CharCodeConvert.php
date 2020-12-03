<?php
declare(strict_types=1);

namespace Ydin\Encode;

/**
 * 單一字符的簡易轉換
 * 如果不在這個指定範圍, 則不轉換
 *
 * @package Ydin\Encode
 */
class CharCodeConvert
{

    /**
     *  0 -> a
     *  1 -> b
     *  2 -> c
     *  3 -> d
     *  4 -> e
     *  5 -> f
     *  6 -> g
     *  7 -> h
     *  8 -> i
     *  9 -> j
     *
     * @param string $originString
     * @return string
     */
    static public function numberToEnglish(string $originString): string
    {
        $result = '';
        for ($i = 0; $i < strlen($originString); $i++) {
            $char = $originString[$i];
            $charNumber = (string)ord($char);
            if ($charNumber >= 48 && $charNumber <= 57) {
                // allow scope
                $englishCharNumber = $charNumber - 48 + 97;
                $result .= (string)chr($englishCharNumber);
            } else {
                $result .= (string)$char;
            }
        }

        return $result;
    }

    /**
     *  a -> 0
     *  b -> 1
     *  c -> 2
     *  d -> 3
     *  e -> 4
     *  f -> 5
     *  g -> 6
     *  h -> 7
     *  i -> 8
     *  j -> 9
     *
     * @param string $originString
     * @return string
     */
    static public function englishToNumber(string $originString): string
    {
        $result = '';
        for ($i = 0; $i < strlen($originString); $i++) {
            $char = $originString[$i];
            $charNumber = (string)ord($char);
            if ($charNumber >= 97 && $charNumber <= 106) {
                // allow scope
                $theNumber = $charNumber - 97;
                $result .= (string)$theNumber;
            } else {
                $result .= (string)$char;
            }
        }

        return $result;
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------


}
