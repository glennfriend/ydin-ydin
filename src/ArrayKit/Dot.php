<?php
namespace Cor\Ydin\ArrayKit;

/**
 * DataConverge
 *
 * @version     1.0.0
 * @package     Cor\Ydin\ArrayKit
 */
class Dot
{

    /**
     * 產生 instance
     * 包裝後可以直接以 function 方式使用
     *      - $dot('user.email')
     *      - $dot('user.friend.0.name')
     *
     * @see Cor\Ydin\ArrayKit\DotInstance
     * @param  array
     * @return wrap closure object
     */
    static public function factory(Array $items)
    {
        $wrap = function($keyword, $defaultValue=null) use ($items)
        {
            $dot = new DotInstance($items);
            return $dot->get($keyword, $defaultValue);
        };
        return $wrap;
    }

}




