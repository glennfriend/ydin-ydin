<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Utility\Log\Concerns;

use Ydin\ThirdParty\Laravel\Utility\Log\PsrLoggerBridge;

trait Loggable
{


    /**
     * e.g.
     *      $this->log()->debug('hello world');
     *
     * @return PsrLoggerBridge
     */
    protected function log(): PsrLoggerBridge
    {
        return $this->_log([
            'channelName' => null,
        ]);
    }

    /**
     * laravel log bridge
     *
     *
     * @param array $options
     * @return PsrLoggerBridge
     */
    protected function _log(array $options = []): PsrLoggerBridge
    {
        /**
         * @var PsrLoggerBridge $logger
         */
        $logger = app(PsrLoggerBridge::class);
        $logger->setOptions($options);
        return $logger;
    }
}
