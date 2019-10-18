<?php
declare(strict_types=1);
namespace Ydin\Sql;

/**
 * Convert
 *
 * @package Ydin\Sql
 */
class Convert
{

    /**
     * PDO::ATTR_EMULATE_PREPARES 如果設定為 true 時
     * 在 bind params 時可以使用 :key 的方式傳遞參數
     * 但是會有效能上的問題
     * 可以參考
     *      https://medium.com/wetprogrammer/php-%E9%A8%99%E4%BD%A0-pdo-prepare-%E4%B8%A6%E6%B2%92%E6%9C%89%E6%BA%96%E5%82%99%E5%A5%BD-600e15cd4cfe
     *
     * 這裡的方式是將 :key 的方式幫你轉換為 ?
     * 例如
     *
     *      $sql = 'select :name from table where name = :name or email = :email'
     *      $binds = [
     *          'name' => 'alice'
     *          'email' => 'alice@mail.com'
     *      ];
     *
     * 轉換為
     *
     *      $sql = 'select ? from table where name = ? or email = ?'
     *      $binds = [
     *          'alice', 'alice', 'alice@mail.com'
     *      ];
     *
     */
    public static function convertPreparedStatementAboutAttribEmulation(string $sql, array $bindings): array
    {
        $sqlResult = '';
        $bindingsResult = [];

        preg_match_all("/:[a-zA-z0-9]+/s", $sql, $matches);
        $matches = $matches[0];
        foreach ($matches as $matche) {
            foreach ($bindings as $bindingKey => $bindingValue) {
                if ($matche === ':' . $bindingKey) {
                    $bindingsResult[] = $bindingValue;
                }
            }
        }

        $sqlResult = preg_replace("/:[a-zA-z0-9]+/s", '?', $sql);

        // debug
        // print_r($bindings);
        //
        // print_r($matches);
        // echo $sqlResult . "\n";
        // print_r($bindingsResult);

        return [$sqlResult, $bindingsResult];
    }

}
