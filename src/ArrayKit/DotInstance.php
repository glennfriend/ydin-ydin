<?php
declare(strict_types=1);
namespace Ydin\ArrayKit;

/**
 * 使用 . 符號的方式, 將陣列由字串的方式來 取得
 * Data Converge
 *
 * example
 *
 *      // data
 *      $stdClass->user->email
 *      $array['user']['email']
 *
 *      // create dot instance
 *      $dotInstance = new Ydin\ArrayKit\DotInstance($stdClass);
 *
 *      // 如果該值不存在, 則抓取 null 值
 *      $dotInstance->get('user.email', 'none@localhost');
 *
 *      // 索引值如果是數值, 也可以直接使用
 *      $dotInstance->get('user.friend.0.name', null);
 *
 * @version 1.0.0
 * @package Ydin\ArrayKit
 *
 */
class DotInstance
{
    /**
     *
     */
    protected $data = null;

    /**
     *
     */
    public function __construct($data)
    {
        $this->data = $this->convertObjectToArray($data);
    }

    /**
     *
     */
    public function get($keyword, $defaultValue=null)
    {
        $pieces = explode('.', trim($keyword));
        $data = $this->data;

        foreach ( $pieces as $piece ) {
            $piece = trim($piece);
            if ( !array_key_exists($piece, $data) ) {
                return $defaultValue;
            }
            $data = $data[$piece];
            $data = $this->convertObjectToArray($data);
        }
        return $data;
    }

    /**
     *  取值的方式統一使用 array
     *  所以如果是 stdClass 則須要轉為 array
     */
    private function convertObjectToArray($data)
    {
        if ( is_object($data) ) {
            $data = (array) $data;
        }
        return $data;
    }

}
