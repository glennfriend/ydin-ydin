<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Log;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Log;

/**
 * Class InfoMonitor
 *
 * @version 1.0.0
 * @package Ydin\ThirdParty\Laravel\Log
 */
class InfoMonitor
{
    /**
     * 是否 顯示/儲存 訊息
     * @var bool
     */
    private $isShowMessage = false;

    /**
     * 每間隔一段時間, 例如 每超過 60 秒, 如果有執行到程式, 就會觸發 message 要做的事
     *
     * @var int seconds
     */
    private $everyTime;

    /**
     * 記錄最後一次顯示的時間
     *
     * @var int
     */
    private $saveLastShowTime;

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
        $this->id = substr(md5(uniqid()), 0, 4);
        $this->startTime = null;
    }

    /**
     * @param string|null $message
     * @param array $options
     */
    public function start(?string $message = null, array $options = [])
    {
        $options += [
            'everyTime'     => 5 * 60,  // 預設每超過 5 分鐘 記錄/顯示 執行的間隔時間
            'isShowMessage' => false,
            'timezone'      => 'Asia/Taipei',
        ];

        $this->everyTime = (float)($options['everyTime'] ?? 60);
        $this->isShowMessage = (bool)($options['isShowMessage'] ?? false);
        $this->startTime = $this->getFloatMicrotime();
        $this->timezone = $options['timezone'];

        $this->showEveryTime($message);
    }

    /**
     * 每一段時間, 例如 每 1 分鐘
     * 但是程式要執行到才會知道是否過了時間
     * 並不能準確的在一個時間點上被執行到
     *
     * @param string|null $message
     */
    public function showEveryTime(string $message = null)
    {
        if (!$this->saveLastShowTime) {
            // first time, to show and log
            //$this->startTime = $this->getFloatMicrotime();
        } elseif (($this->getFloatMicrotime() - $this->saveLastShowTime) > $this->everyTime) {
            // 已超過等待時間, to show and log
        } else {
            // not show, not log
            return;
        }

        $this->saveLastShowTime = $this->getFloatMicrotime();
        $this->showCurrent($message);
    }

    /**
     * 忽略 $everyTime, 立即顯示現在訊息
     *
     * @param string|null $message
     */
    public function showCurrent(string $message = null)
    {
        $this->message($message);
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    private function message($message = null)
    {
        $message = (string)$message;
        if ($this->isShowMessage) {
            $this->showMessage($message);
        }
        $this->log($message);
    }

    private function showMessage(string $message)
    {
        $message = $this->makeMessage($message);
        echo "[{$this->getCurrentDate()}]{$message}" . "\n";
    }

    private function log(string $message)
    {
        Log::debug($this->makeMessage($message));
    }

    private function makeMessage(string $message): string
    {
        return sprintf("[%4s][%8s][% 5.1f] %s", $this->id, $this->getMemoryUsed(), $this->getTimeDiff(), $message);
    }

    // --------------------------------------------------------------------------------
    //  get information
    // --------------------------------------------------------------------------------

    private function getMemoryUsed()
    {
        return round((memory_get_peak_usage(true) / 1024 / 1024), 2) . " MB";
    }

    private function getTimeDiff()
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

    private function getFloatMicrotime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

}
