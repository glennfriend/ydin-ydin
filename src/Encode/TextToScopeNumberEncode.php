<?php
declare(strict_types=1);

namespace Ydin\Encode;

/**
 * @package Ydin\Encode
 */
class TextToScopeNumberEncode
{

    /**
     * 將一個 string 轉換為一個範圍內的編號
     * 可以為分散分流做依據
     * 預設為 0~9
     *
     * @param string $text
     * @param int $scope
     * @return int
     */
    static public function build(string $text, int $scope = 10): int
    {
        $encode = md5($text);
        $total = 0;
        for ($i = 0; $i < 7; $i++) {
            $char = substr($encode, $i, 1);
            $total += ord($char);
        }

        return ($total % $scope);
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------


}
