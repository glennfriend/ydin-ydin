<?php
namespace Cor\Ydin\CreditCard;

/**
 * 本程式僅用於猜測卡號
 *
 * 本程式修改自
 *      composer: https://github.com/inacho/php-credit-card-validator
 *      version: 1.0.2
 *
 * 修改的部份為
 *      - 移除 luhn 的驗証
 *      - 只要求最基本的 number prefix
 *      - 新增 laser
 *
 * @version 1.0.0
 * @package Cor\Ydin\CreditCard
 */
class Guess
{
    /**
     * @var array
     */
    protected static $cards = array(

        // Debit cards must come first, since they have more specific patterns than their credit-card equivalents.
        'visaelectron' => array(
            'type' => 'visaelectron',
            'pattern' => '/^4(026|17500|405|508|844|91[37])/',
        ),
        'maestro' => array(
            'type' => 'maestro',
            'pattern' => '/^(5(018|0[23]|[68])|6(39|7))/',
        ),
        'forbrugsforeningen' => array(
            'type' => 'forbrugsforeningen',
            'pattern' => '/^600/',
        ),
        'dankort' => array(
            'type' => 'dankort',
            'pattern' => '/^5019/',
        ),

        // Credit cards
        'visa' => array(
            'type' => 'visa',
            'pattern' => '/^4/',
        ),
        'mastercard' => array(
            'type' => 'mastercard',
            'pattern' => '/^(5[0-5]|2[2-7])/',
        ),
        'amex' => array(
            'type' => 'amex',
            'pattern' => '/^3[47]/',
        ),
        'dinersclub' => array(
            'type' => 'dinersclub',
            'pattern' => '/^3[0689]/',
        ),
        'discover' => array(
            'type' => 'discover',
            'pattern' => '/^6([045]|22)/',
        ),
        'unionpay' => array(
            'type' => 'unionpay',
            'pattern' => '/^(62|88)/',
        ),
        'jcb' => array(
            'type' => 'jcb',
            'pattern' => '/^35/',
        ),

        // 自行加上去的
        // 參考自 https://creditcardjs.com/credit-card-type-detection
        'laser' => array(
            'type' => 'laser',
            'pattern' => '/^(6304|6706|6771|6709)/',
        ),

    );

    public static function cardType($number)
    {
        foreach (self::$cards as $type => $card) {
            if (preg_match($card['pattern'], $number)) {
                return $type;
            }
        }
        return '';
    }

}
