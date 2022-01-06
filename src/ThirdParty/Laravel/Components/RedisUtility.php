<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Redis;

use Closure;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Log;
use Predis\Connection\ConnectionException;
use Predis\Response\ServerException;

/**
 * Laravel Redis Utility
 *
 * @version 0.1.0
 * @package Ydin\ThirdParty\Laravel\Redis
 */
class RedisUtility
{
    /**
     * @var bool
     */
    private $isShowMessage = false;

    /**
     * 程式在 redis 中斷時, 可以進入等待狀況
     * 直到 redis 恢復後, 重新工作
     * 通常用在 command line, 需要大量且長時間的執行作業, 例如 import 1000萬 筆的 csv 資料
     *
     * feature
     *      - sleep loop
     *      - 如果 Redis 沒有啟用, 進行 sleep loop 的等待
     *      - 沒有等待上限
     * 注意
     *      - 重新連接之後, 是重新呼叫 Closure, 並 "不是" 從執行中斷的地方接續執行
     *      - 有大量資料時, 請留意 redis memory leak
     *
     * @param Closure $func
     * @param array $options
     */
    public function connectWaitGuardAgainst($func, array $options = [])
    {
        $options += [
            'sleep'         => 60,
            'isShowMessage' => false,
        ];
        $sleep = $options['sleep'];
        $this->isShowMessage = $options['isShowMessage'];

        do {
            try {

                $func();
                break;

            } catch (ConnectionException $exception) {

                $message = "[Predis\\Connection\\ConnectionException] {$exception->getMessage()}, sleep {$sleep} ...";
                $this->message($message);
                sleep($sleep);

            } catch (ServerException $exception) {

                $message = "[Predis\\Response\\ServerException] {$exception->getMessage()}, sleep {$sleep} ...";
                $this->message($message);
                sleep($sleep);

            }
        } while (true);
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    protected function getCurrentDate($timezone = 'Asia/Taipei'): string
    {
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone($timezone));
        return $date->format('Y-m-d H:i:s');
    }

    protected function message(string $message)
    {
        $this->showMessage($message);
        $this->log($message);
    }

    protected function makeMessage(string $message): string
    {
        return sprintf("[RedisUtility][%8s] %s", $this->getMemoryUsed(), $message);
    }

    protected function showMessage(string $message)
    {
        if (!$this->isShowMessage) {
            return;
        }
        $message = $this->makeMessage($message);
        echo "[{$this->getCurrentDate()}]{$message}" . "\n";
    }

    protected function log(string $message)
    {
        Log::info($this->makeMessage($message));
    }

    protected function getMemoryUsed()
    {
        return round((memory_get_peak_usage(true) / 1024 / 1024), 2) . " MB";
    }

}


/*
// example

    foreach ($hugeNumberUsers as $user) {
        $func = function () use ($service, $user) {
            $service->addUser($user);
        };
        $redisUtility->connectWaitGuardAgainst($func, ['isShowMessage' => 1]);
    }

*/
