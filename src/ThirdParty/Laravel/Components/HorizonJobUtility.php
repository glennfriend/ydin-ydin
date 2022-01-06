<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Horizon;

use DateTime;
use DateTimeZone;
use Exception;
use Laravel\Horizon\Contracts\WorkloadRepository;
use Illuminate\Support\Facades\Log;
use Predis\Connection\ConnectionException;
use Predis\Response\ServerException;

/**
 * Laravel Horizon jobs Utility
 *
 * @version 0.1.0
 * @package Ydin\ThirdParty\Laravel\Horizon
 */
class HorizonJobUtility
{
    /**
     * @var WorkloadRepository
     */
    private $workloadRepository;

    /**
     * @var bool
     */
    private $isShowMessage = false;

    /**
     * @param WorkloadRepository $workloadRepository
     */
    public function __construct(WorkloadRepository $workloadRepository)
    {
        $this->workloadRepository = $workloadRepository;
    }

    /**
     * 防止過多的 jobs 進到 queue 裡面
     *
     * feature
     *      - sleep loop
     *      - calculation jobs from Horizon
     *      - 防止 queue service memory 爆作, 副作用為 阻塞
     *      - 如果 Horizon 沒有啟用, 進行 sleep loop 的等待, 目的是讓 jobs 不會被 dispatch
     * 注意
     *      - 會阻塞 jobs 進到 queue 裡面
     *      - 如果主程式在 長時間的等待之下 中斷, 後面的 jobs 將不會被 dispatch
     *
     * 程式邏輯
     *      計算現在如果有 200 jobs 以上在 queue 裡面, 就進行 sleep 等待
     *      等到低於 200 jobs 的時候
     *      才會放行
     *
     * @param array $options
     * @throws Exception
     */
    public function wait(array $options = [])
    {
        $options += [
            'limit'         => 350,
            'sleep'         => 60,
            'isShowMessage' => false,
        ];
        $limit = $options['limit'];
        $sleep = $options['sleep'];
        $this->isShowMessage = $options['isShowMessage'];

        do {

            try {

                if ($this->isHorizonEnable()) {

                    $currentJobs = 0;
                    foreach ($this->getWorkload() as $info) {
                        $currentJobs += $info['length'];
                    }

                    if ($currentJobs > $limit) {
                        $message = "jobs total {$currentJobs}, sleep loop {$sleep}";
                        $this->message($message);
                        sleep($sleep);
                    } else {
                        break;
                    }

                } else {

                    // Horizon 沒有啟動
                    $message = "Horizon disabled, sleep loop 90 ...";
                    $this->message($message);
                    sleep(90);

                }

            } catch (ConnectionException $exception) {

                $message = "[Predis\\Connection\\ConnectionException] {$exception->getMessage()}, sleep loop 90 ...";
                $this->message($message);
                sleep(90);

            } catch (ServerException $exception) {

                $message = "[Predis\\Response\\ServerException] {$exception->getMessage()}, sleep loop 90 ...";
                $this->message($message);
                sleep(90);

            }

        } while (true);
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    protected function getWorkload(): array
    {
        return collect($this->workloadRepository->get())->sortBy('name')->values()->toArray();
    }

    protected function isHorizonEnable(): bool
    {
        if (!$this->getWorkload()) {
            return false;
        }

        return true;
    }

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
        return sprintf("[HorizonJobUtility][%8s] %s", $this->getMemoryUsed(), $message);
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
