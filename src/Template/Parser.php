<?php
declare(strict_types=1);
namespace Ydin\Template;

/**
 * Parser
 * 
 * Twig filter example
 *      https://twig.symfony.com/doc/2.x/filters/filter.html
 *
 * @version 1.0.0
 * @package Ydin\Template
 */
class Parser
{

    /**
     * parse text template to variables
     *
     * from
     *      {{ var1 }}
     *      {{ var2 | raw }}
     *      {{ var3 happy }}
     * to
     *      ['var1', 'var2', 'var3']
     *
     * @param string $template
     * @return array
     */
    public function parseTemplateVariables(string $template)
    {
        // test only
        // $template .= ' {{var3 33}} ';


        // 第一階段: 取得 {{ }} 裡面的值
        preg_match_all("/{{(.+)}}/sU", $template, $matches);
        if (! is_array($matches) || ! is_array($matches[1])) {
            return [];
        }
        $allMessyVariable = $matches[1];


        // 第二階段: 從這些字串中, 取得字串前面符合規則的 變數
        $result = [];
        foreach ($allMessyVariable as $messyVariable) {
            $messyVariable = strtolower(trim($messyVariable));
            $isMatch = preg_match('/^[a-zA-z0-9_]+/', $messyVariable, $matches);
            if (! $isMatch) {
                continue;
            }
            if (! $matches || ! $matches[0]) {
                continue;
            }

            $result[] = $matches[0];
        }

        return $result;
    }

}
