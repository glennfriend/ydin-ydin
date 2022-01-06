<?php

declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Enums\Concerns;

use Exception;

/**
 * e.g.

    class ExampleStatus
    {
        use Enumerable;

        public const UNKNOWN    = 0;
        public const ENABLED    = 1;
        public const DISABLED   = 2;

        private static array $valueToName = [
            self::UNKNOWN   => 'unknown',
            self::ENABLED   => 'enabled',
            self::DISABLED  => 'disabled',
        ];
    }

    YourTypeStatus::ENABLED

    YourTypeStatus::name(0);            // unknown
    YourTypeStatus::value('unknown');   // 0

 */
trait Enumerable
{
    /**
     * please create it
     */
    /*
        public const UNKNOWN = 0;
        public const YES     = 1;
        public const NO      = 2;

        private static array $valueToName = [
            self::UNKNOWN => 'unknown',
            self::YES     => 'yes',
            self::NO      => 'no',
        ];
     */

    // --------------------------------------------------------------------------------
    //  public
    // --------------------------------------------------------------------------------

    /**
     * @param int $value
     * @return string
     * @throws Exception
     */
    public static function name(int $value): string
    {
        if (!isset(self::$valueToName[$value])) {
            throw new Exception(sprintf('Enum %s NAME not defined: %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }

    /**
     * @param string $name
     * @return int
     * @throws Exception
     */
    public static function value(string $name): int
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new Exception(sprintf('Enum %s VALUE not defined: %s', __CLASS__, $name));
        }
        return constant($const);
    }
}
