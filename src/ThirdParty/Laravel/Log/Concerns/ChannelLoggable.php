<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Utility\Log\Concerns;

use Ydin\ThirdParty\Laravel\Utility\Log\PsrLoggerBridge;

trait ChannelLoggable
{
    protected String $channelName;

    /**
     * e.g.
     *      $this->log()->debug('hello world');
     *
     * @return PsrLoggerBridge
     */
    protected function log(): PsrLoggerBridge
    {
        return $this->_channelLog([
            'channelName' => $this->channelName,
        ]);
    }

    /**
     * laravel log channel bridge
     * NOTE: package ServiceProvider 必須先定義 logging.channels.your-custom-name
     *
     * @param array $options
     * @return PsrLoggerBridge
     */
    protected function _channelLog(array $options = []): PsrLoggerBridge
    {
        $logger = app(PsrLoggerBridge::class);
        $logger->setOptions($options);
        return $logger;
    }
}
