<?php

declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Log;

use Log;

/**
 * Class MonitorAlertLog
 * 監視異常 憶記體用量 執行時間
 *
 * @version 1.0.0
 * @package Ydin\ThirdParty\Laravel\Log
 */
class MonitorAlertLog
{
    protected array $options = [];
    protected ?float $startTime = null;

    public function __construct()
    {
        $this->resetDefaultValues();
    }

    public function watch(?string $message = null, array $options = [])
    {
        if (!isset($this->startTime)) {
            $this->startTime = $this->getFloatMicrotime();
        }
        if (isset($options[$key = 'memoryLimit'])) {
            $this->options[$key] = (int)$options[$key];
        }
        if (isset($options[$key = 'executeTimeLimit'])) {
            $this->options[$key] = (int)$options[$key];
        }

        $this->message((string)$message);
    }

    protected function makeAlertInfos(): array
    {
        // 記憶體
        if ($this->getMemoryUsedMegabyte() >= 100) {
            $information['excessive_memory_usage_100_MB'] = true;
        }
        if ($this->getMemoryUsedMegabyte() >= $this->options['memoryLimit']) {
            $information['too_much_memory_usage'] = $this->getMemoryUsedMegabyteFormat();
        }

        // 執行秒數
        if ($this->getTimeDiff() >= 90) {
            $information['execution_time_exceeds_1_minute_and_30_seconds'] = true;
        }
        if ($this->getTimeDiff() >= $this->options['executeTimeLimit']) {
            $information['execution_time_is_too_long'] = number_format($this->getTimeDiff(), 2);
        }

        return $information ?? [];
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------
    protected function resetDefaultValues()
    {
        $this->id = substr(md5(uniqid()), 0, 4);
        $this->startTime = null;
        $this->options = [
            'memoryLimit'      => 64,   // MB size
            'executeTimeLimit' => 60,   // seconds
        ];
    }

    protected function message(string $message)
    {
        if (!$this->allowCreateLog()) {
            return;
        }

        $message = sprintf("[%4s] %s", $this->id, $message);
        $this->log($message, $this->makeAlertInfos());
    }

    protected function log(string $message, array $information)
    {
        // use Facades, not for Illuminate\Support\Facades\Log
        Log::notice($message, $information);
    }

    protected function allowCreateLog(): bool
    {
        return (count($this->makeAlertInfos()) > 0);
    }

    // --------------------------------------------------------------------------------
    //  get information
    // --------------------------------------------------------------------------------

    /**
     * return MB size
     */
    protected function getMemoryUsedMegabyte(): int
    {
        return (int)round((memory_get_peak_usage(true) / 1024 / 1024), 2);
    }

    protected function getMemoryUsedMegabyteFormat(): string
    {
        return $this->getMemoryUsedMegabyte() . " MB";
    }

    protected function getTimeDiff(): float
    {
        return ($this->getFloatMicrotime() - $this->startTime);
    }

    protected function getFloatMicrotime(): float
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}
