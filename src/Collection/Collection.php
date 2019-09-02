<?php
namespace Cor\Ydin\Collection;

/**
 * 將陣列資料打包為 Collection Object
 * 以方便處理資料, 功能有
 *     - filter
 *     - sort
 *     - get
 *     - find
 *
 * @version 1.0.0
 * @package Cor\Ydin\Collection
 */
class Collection
{
    private $items = [];

    // --------------------------------------------------------------------------------
    // get & find
    // --------------------------------------------------------------------------------

    /**
     *  @param $oration     - 條件的敘述句
     *  @param $helpOration - 補助的敘述句
     *  @param $callback
     *  @return array
     */
    public function find($oration, $helpOration=null, $callback=null)
    {
        list($field, $condition, $value, $helpOration) = $this->_parseOrationString($oration, $helpOration);
        return $this->_findByCondition($field, $condition, $helpOration, $value);
    }

    public function get($oration, $helpOration=null)
    {
        $items = $this->find($oration, $helpOration);
        if (!isset($items[0])) {
            return [];
        }
        return $items[0];
    }

    private function _findByCondition($field, $condition, $helpOration, $value)
    {
        $newItems = [];
        foreach( $this->items as $index => $item ) {
            if (!isset($item[$field])) {
                return [];
            }
            $content = $item[$field];

            switch ($helpOration) {
                case '/i':
                    $content = strtolower($content);
                    $value   = strtolower($value);
                    break;
            }

            $isAppend = false;
            switch ($condition) {
                case '==' : if ($content ==  $value) {$isAppend = true; }   break;
                case '!=' : if ($content !=  $value) {$isAppend = true; }   break;
                case '===': if ($content === $value) {$isAppend = true; }   break;
                case '!==': if ($content !== $value) {$isAppend = true; }   break;
                case '>'  : if ($content >   $value) {$isAppend = true; }   break;
                case '>=' : if ($content >=  $value) {$isAppend = true; }   break;
                case '<'  : if ($content <   $value) {$isAppend = true; }   break;
                case '<=' : if ($content <=  $value) {$isAppend = true; }   break;
                case '%':
                    if (false !== strpos($content, $value)) {
                        $isAppend = true;
                    };
                break;
                case 'in':
                    if (in_array($content, explode(',', $value) )) {
                        $isAppend = true;
                    };
                break;
                default:
                    throw new Exception('Error: Ydin\Collection\Collection condition string not found!');
                    exit;
            }

            if ($isAppend) {
                $newItems[] = $this->items[$index];
            }
        }
        return $newItems;
    }

    private function _parseOrationString($oration, $helpOration)
    {
        $tmp = explode(' ',trim($oration));
        $field = trim($tmp[0]);

        if (!isset($tmp[1])) {
            throw new \Exception('Error: Ydin\Collection\Collection condition have problem!');
        }
        $condition  = trim(strtolower($tmp[1]));

        unset($tmp[0],$tmp[1]);
        $value = trim(join(' ', $tmp));

        if (!$field) {
            throw new \Exception('Error: Ydin\Collection\Collection "field" not found!');
        }
        if (!$condition) {
            throw new \Exception('Error: Ydin\Collection\Collection "condition" not found!');
        }
        if (!$value) {
            throw new \Exception('Error: Ydin\Collection\Collection "condition value" not found!');
        }

        $helpOration = trim($helpOration);
        return [$field, $condition, $value, $helpOration];
    }

    // --------------------------------------------------------------------------------
    // insert data
    // --------------------------------------------------------------------------------
    public function insert(Array $item)
    {
        $this->items[] = $item;
    }

    public function insertMany(Array $items)
    {
        foreach ( $items as $item ) {
            $this->items[] = $item;
        }
    }

    // --------------------------------------------------------------------------------
    // output
    // --------------------------------------------------------------------------------
    public function toArray()
    {
        return $this->items;
    }

    // --------------------------------------------------------------------------------
    // filter
    // --------------------------------------------------------------------------------
    public function filter($field, $filterTagString)
    {
        $filterTags = explode(",", $filterTagString);
        foreach ( $filterTags as $tag ) {
            $tag = trim(strtolower($tag));
            $this->_filterFieldValueByTag($field, $tag);
        }
    }

    private function _filterFieldValueByTag($field, $tag)
    {
        foreach ( $this->items as $index => $item ) {

            if (!isset($item[$field])) {
                continue;
            }

            switch ($tag) {
                case 'strtolower':
                    $this->items[$index][$field] = strtolower($item[$field]);
                    break;
                case 'trim':
                    $this->items[$index][$field] = trim($item[$field]);
                    break;
                case 'to_int':
                    $this->items[$index][$field] = (int) $item[$field];
                    break;
                case 'to_strtoing':
                    $this->items[$index][$field] = (string) $item[$field];
                    break;
            }

        }
    }

    // --------------------------------------------------------------------------------
    // unique array by field name
    // 有區分大小寫
    // --------------------------------------------------------------------------------
    public function unique($field)
    {
        $newItems = [];
        $uniqueKey = [];
        foreach ( $this->items as $item ) {
            $key = $item[$field];
            if (isset($uniqueKey[$key])) {
                continue;
            }
            $uniqueKey[$key] = true;
            $newItems[] = $item;
        }
        $this->items = $newItems;
    }

    // --------------------------------------------------------------------------------
    // sort
    //      $orationString
    //          EX. "name ASC, age DESC"
    //          ->  [name, SORT_ASC, age, SORT_DESC]
    // --------------------------------------------------------------------------------
    public function sort($orationString)
    {
        $sortBy = $this->_filterSortString($orationString);

        if ( !isset($sortBy[0]) || !isset($sortBy[1]) ) {
            return;
        }

        $oneValues = [];
        foreach ( $this->items as $item ) {
            $oneValues[] = $item[$sortBy[0]];
        }

        if (2 == count($sortBy)) {
            array_multisort(
                $oneValues, $sortBy[1],
                $this->items
            );
            return;
        }

        $twoValues = [];
        foreach ( $this->items as $item ) {
            $twoValues[] = $item[$sortBy[2]];
        }

        if (4 == count($sortBy)) {
            array_multisort(
                $oneValues, $sortBy[1],
                $twoValues, $sortBy[3],
                $this->items
            );
            return;
        }

    }

    private function _filterSortString($orationString)
    {
        $sortKeys = [];

        foreach ( explode(",", $orationString) as $oration ) {
            $oration = preg_replace('/[ ]+/', ' ', $oration );  // 多個空白轉為一個空白
            $oration = trim($oration);
            $fields = explode(" ", trim($oration));
            list($field, $sortBy) = $fields;

            $sortKey = SORT_DESC;
            if ('desc' !== strtolower($sortBy)) {
                $sortKey = SORT_ASC;
            }

            $sortKeys[] = $field;
            $sortKeys[] = $sortKey;
        }
        return $sortKeys;
    }

}


//class CollectionInstance
