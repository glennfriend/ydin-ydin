<?php
declare(strict_types=1);
namespace Ydin\String;

/**
 * 將中文、英文、數字切開
 * "Test 中文數字 1000 切割測試"
 * 
 * 
 */
class TextCut
{

    /**
     * 未整理 未測試
     */
    public static function toArray($text)
    {
        $str = 'Test中文數字1000切割測試';

        // 所有字元都切開
        preg_match_all('/./u', $str, $m); // $m[0]：T e s t 中 文 數 字 1 0 0 0 切 割 測 試
        print_r(preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY)); // T e s t 中 文 數 字 1 0 0 0 切 割 測 試
        
        // 中、英文字切開
        preg_match_all('/\p{Latin}+|\p{Han}+|[0-9]+/u', $str, $m); // $m[0]：Test 中文數字 1000 切割測試
        print_r(preg_split('/(?<!\p{Latin})(?=\p{Latin})|(?<!\p{Han})(?=\p{Han})|(?<![0-9])(?=[0-9])/u', $str, -1, PREG_SPLIT_NO_EMPTY)); // Test 中文數字 1000 切割測試
        
        // 中、英文字切開，中文字再每個字元切開
        print_r(preg_split("/(?<!\p{Latin})(?=\p{Latin}+)|(?=\p{Han})|(?<!\d)(?=\d)/u", $str, -1, PREG_SPLIT_NO_EMPTY)); // Test 中 文 數 字 1000 切 割 測 試
        preg_match_all('/\p{Latin}+|\p{Han}|[0-9]+/u', $str, $m); // $m[0]：Test 中 文 數 字 1000 切 割 測 試
        preg_match_all('/\p{Latin}+|\p{Han}|\d+/u', $str, $m); // $m[0]：Test 中 文 數 字 1000 切 割 測 試
        
    }

}
