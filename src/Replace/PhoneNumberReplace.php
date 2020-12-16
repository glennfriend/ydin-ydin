<?php
declare(strict_types=1);

namespace Ydin\Replace;

/**
 * @version 0.1.0
 * @package Ydin\Replace
 */
class PhoneNumberReplace
{
    /**
     * US phone number replace
     * 美國電話號碼代換
     *
     * feature
     *      - 原本的電話格式
     *          - 888-999-0000
     *          - (888) 999-0000
     *      - 代換之後的電話格式
     *          - 8889990000
     *      - 程式中含有自定義邏輯
     *          - url 參數名稱 (請查閱程式碼)
     *
     * @param string $url
     * @return string
     */
    static public function replacePhoneNumber(string $url): string
    {
        $replaces = [];
        $replaces = static::replaceUrlFormat1($replaces, $url);
        $replaces = static::replaceUrlFormat2($replaces, $url);

        $text = $url;
        foreach ($replaces as $replace) {
            $text = preg_replace($replace['pattern'], $replace['replacement'], $text);
        }

        return $text;
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * replace from
     *      onr_call=222-555-0123
     *      mytag=222-555-0123
     *
     * replace to
     *      222-555-0123 to 2225550123
     *
     * @param array $replaces
     * @param string $url
     * @return array
     */
    static private function replaceUrlFormat1(array $replaces, string $url): array
    {
        if (preg_match_all("/(mytag|onr_call)=(\d{3})-(\d{3})-(\d{4})/isU", $url, $matches)) {

            $total = count($matches[0]);
            for ($index = 0; $index < $total; $index++) {

                $name = $matches[1][$index];
                $data1 = $matches[2][$index];
                $data2 = $matches[3][$index];
                $data3 = $matches[4][$index];

                $replaces[] = [
                    'pattern'     => "/{$name}=(\d{3})-(\d{3})-(\d{4})/i",
                    'replacement' => "{$name}={$data1}{$data2}{$data3}",
                ];
            }
            // dump($matches); dd($replaces);
        }

        return $replaces;
    }

    /**
     * replace from
     *      onr_call=(222) 555-0123
     *      mytag=(222) 555-0123
     *
     * replace to
     *      (222) 555-0123 to 2225550123
     *
     * tips
     *      在網址中, 空白會是以 %20 顯示
     *      (888) 999-1111 --> (888)%20999-1111
     *
     * @param array $replaces
     * @param string $url
     * @return array
     */
    static private function replaceUrlFormat2(array $replaces, string $url): array
    {
        if (preg_match_all("/(mytag|onr_call)=\((\d{3})\)%20(\d{3})-(\d{4})/isU", $url, $matches)) {

            $total = count($matches[0]);
            for ($index = 0; $index < $total; $index++) {

                $name = $matches[1][$index];
                $data1 = $matches[2][$index];
                $data2 = $matches[3][$index];
                $data3 = $matches[4][$index];

                $replaces[] = [
                    'pattern'     => "/{$name}=\((\d{3})\)%20(\d{3})-(\d{4})/i",
                    'replacement' => "{$name}={$data1}{$data2}{$data3}",
                ];
            }
            // dump($matches); dd($replaces);
        }

        return $replaces;
    }

}
