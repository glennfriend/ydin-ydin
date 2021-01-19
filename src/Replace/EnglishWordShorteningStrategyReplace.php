<?php
declare(strict_types=1);

namespace Ydin\Replace;

/**
 * @version 0.1.0
 * @package Ydin\Replace
 */
class EnglishWordShorteningStrategyReplace
{
    /**
     * English word shortening strategy
     * 英語單詞縮短策略
     *      - 如果原始文字夠長, 就不進行縮字
     *      - 若過長, step 1, 原始文字 兩個字的英文字開頭大寫, 去除所有空白及特殊符號
     *      - 若過長, step 2, 原始文字 兩個字的英文字開頭大寫, 去除三個字以上的英文字的 aeiou 文字, 去除所有空白及特殊符號
     *      - 若過長, step 3, 原始文字 去除最後 1-n 個英文單字, 兩個字的英文字開頭大寫, 去除三個字以上的英文字的 aeiou 文字, 去除所有空白及特殊符號
     *
     * e.g.
     *      [] Village of Lots of People
     *      -> VillageOfLotsOfPeople
     *      -> VllgOfLtsOfPpl
     *      -> VllgOfLtsOf
     *      -> VllgOfLts
     *      -> VllgOf
     *      -> Vllg
     *      -> (null)
     *
     * 為什麼 step 3 裡面不直接使用 step 2 的程式碼?
     *      縮短策略並不絕對是 使用/套用 之前的規則, 邏輯在未來可能會改變, 所以請獨立處理每一個 step
     *
     * @param string $originText
     * @param int|null $length
     * @return string|null
     */
    static public function shortening(string $originText, int $length = null): ?string
    {
        if (!$length) {
            return $originText;
        }
        if (mb_strlen($originText) <= $length) {
            return $originText;
        }
        $originText = trim($originText);
        $originText = static::convertSpecialCharacters($originText);
        $words = explode(' ', $originText);

        //
        $text = static::step1($words);
        if (mb_strlen($text) <= $length) {
            return $text;
        }

        //
        $text = static::step2($words);
        if (mb_strlen($text) <= $length) {
            return $text;
        }

        //
        $text = static::step3($words, $length);
        if (mb_strlen($text) <= $length) {
            return $text;
        }

        //
        return null;
    }

    // --------------------------------------------------------------------------------
    //  step by step
    // --------------------------------------------------------------------------------

    static private function step1(array $words): string
    {
        $text = '';
        foreach ($words as $word) {
            $text .= static::twoWordsToCapitalizeTheFirstWord($word);
        }

        return $text;
    }

    static private function step2(array $words): string
    {
        $text = '';
        foreach ($words as $word) {
            $word = static::twoWordsToCapitalizeTheFirstWord($word);
            if (mb_strlen($word) !== 2) {
                $word = static::removeAllVowels($word);
            }

            $text .= $word;
        }

        return $text;
    }

    static private function step3(array $words, int $length): string
    {
        while (count($words) > 0) {
            $text = '';
            foreach ($words as $word) {
                $word = static::twoWordsToCapitalizeTheFirstWord($word);
                if (mb_strlen($word) !== 2) {
                    $word = static::removeAllVowels($word);
                }
                $text .= $word;
            }

            //
            if (mb_strlen($text) <= $length) {
                break;
            } else {
                array_pop($words);
            }
        }

        return $text ?? '';
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * 如果是 兩個字 的 英文字 就 開頭大寫
     * 否則不處理
     */
    static private function twoWordsToCapitalizeTheFirstWord(string $word): string
    {
        $word = trim($word);
        if (mb_strlen($word) !== 2) {
            return $word;
        }

        return ucfirst($word);
    }

    /**
     * 去除所有的母音
     */
    static private function removeAllVowels(string $word): string
    {
        return preg_replace('/[aeiou]/is', '', $word);
    }

    /**
     * 去除小部份特殊符號
     */
    static private function convertSpecialCharacters(string $text, string $char = ' '): string
    {
        if (mb_strlen($char) !== 1) {
            return $text;
        }

        return preg_replace('/[-_ \.]/s', ' ', $text);
    }

}
