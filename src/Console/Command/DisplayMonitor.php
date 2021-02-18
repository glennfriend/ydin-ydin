<?php
declare(strict_types=1);

namespace Ydin\Console\Command;

use DateTime;
use DateTimeZone;

/**
 * Class DisplayMonitor
 * 立即顯示在 console command 的訊息
 *
 * example:
 *      [YYYY-mm-dd HH:ii:ss][1024 Mb] start
 *      [YYYY-mm-dd HH:ii:ss][1024 Mb] id=xxx name=xxx type=xxx
 *
 * @version 1.0.0
 * @package Ydin\Console\Command
 */
class DisplayMonitor
{
    /**
     * @var string
     */
    private $timezone;

    /**
     * 一開始的時間
     *
     * @var ?float
     */
    private $startTime;

    /**
     *
     */
    public function __construct()
    {
        $this->startTime = null;
    }

    /**
     * @param string|null $message
     * @param array $options
     */
    public function triggerStart(string $message = null, array $options = [])
    {
        static $triggerStartTime = false;
        if ($triggerStartTime) {
            return;
        }

        $options += [
            'timezone' => 'Asia/Taipei',
        ];

        $this->startTime = $this->getFloatMicrotime();
        $this->timezone = $options['timezone'];

        if ($message) {
            $this->enter($message);
        }

        $triggerStartTime = true;
    }

    /**
     * 顯示訊息, 停留在同一行
     *
     * @param string|null $message
     */
    public function show(string $message = null)
    {
        $this->triggerStart();
        $message = (string)$message;
        $this->showMessage($message, false);
    }

    /**
     * 顯示訊息, 換行
     *
     * @param string|null $message
     */
    public function enter(string $message = null)
    {
        $this->triggerStart();
        $message = (string)$message;
        $this->showMessage($message, true);
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    private function showMessage(string $message, bool $isEnter)
    {
        $message = $this->makeMessage($message);
        $message = "[{$this->getCurrentDate()}]{$message}";

        if ($isEnter) {
            echo $message . "\n";
        } else {
            echo "\033[2K" . $message . "\r";
        }
    }

    private function makeMessage(string $message): string
    {
        return sprintf("[%8s][% 5.1f] %s", $this->getMemoryUsed(), $this->getTimeDiff(), $message);
    }

    // --------------------------------------------------------------------------------
    //  get information
    // --------------------------------------------------------------------------------

    private function getMemoryUsed(): string
    {
        return round((memory_get_peak_usage(true) / 1024 / 1024), 2) . " MB";
    }

    private function getTimeDiff(): string
    {
        return (string)($this->getFloatMicrotime() - $this->startTime);
    }

    private function getCurrentDate(): string
    {
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone($this->timezone));

        // $dateFormat = 'c';
        $dateFormat = 'Y-m-d H:i:s';
        return $date->format($dateFormat);
    }

    private function getFloatMicrotime(): float
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

}
