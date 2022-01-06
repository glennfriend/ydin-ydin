<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Utility\Log;

use Exception;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

/**
 * log format
 */
class PsrLoggerBridge implements LoggerInterface
{
    protected array $options = [];

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    // --------------------------------------------------------------------------------
    //  public by LoggerInterface
    // --------------------------------------------------------------------------------

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = [])
    {
        $this->_log($level, $message, $context);
    }

    /**
     * 一般不使用這個等級別
     * @param mixed $message
     * @param array $context
     */
    public function emergency($message, array $context = [])
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * 一般不使用這個等級別
     * @param mixed $message
     * @param array $context
     */
    public function alert($message, array $context = [])
    {
        $this->log('alert', $message, $context);
    }

    /**
     * 一般不使用這個等級別
     * @param mixed $message
     * @param array $context
     */
    public function critical($message, array $context = [])
    {
        $this->log('critical', $message, $context);
    }

    /**
     * 提供 "必須" 要處理的訊息
     *
     * @param mixed $message
     * @param array $context
     */
    public function error($message, array $context = [])
    {
        $this->log('error', $message, $context);
    }

    /**
     * 提供警告訊息, 可以是預期的錯誤
     *
     * @param mixed $message
     * @param array $context
     */
    public function warning($message, array $context = [])
    {
        $this->log('warning', $message, $context);
    }

    /**
     * 一般不使用這個等級別
     * @param mixed $message
     * @param array $context
     */
    public function notice($message, array $context = [])
    {
        $this->log('notice', $message, $context);
    }

    /**
     * 用於 production 提供重要資訊
     *
     * @param mixed $message
     * @param array $context
     */
    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }

    /**
     * 開發/測試 使用
     *
     * @param mixed $message
     * @param array $context
     */
    public function debug($message, array $context = [])
    {
        $this->log('debug', $message, $context);
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * 主要的 log 行為邏輯
     *
     * @param string $level
     * @param mixed $message
     * @param array $context
     */
    private function _log(string $level, $message, array $context = [])
    {
        $options = $this->_getOptions();

        if ($message instanceof Exception) {
            $exception = $message;
            $message = $exception->getMessage();
            $context['isException'] = true;
        } elseif (is_array($message)) {
            // array to string
            $message = var_export($message, true);
        } elseif (is_object($message)) {
            // object to string
            $export = var_export($message, true);
            if (mb_strlen($export) > 1000) {
                $export = substr($export, 0, 1000) . ' ...';
            }
            $message = $export;
        }

        // merge prefix
        if (is_string($message) && $prefix = $this->_getPrefix($options)) {
            $message = "{$prefix} {$message}";
        }

        //
        if (isset($options['channel'])) {
            Log::channel($options['channel'])
                ->$level($message, $context);
        } else {
            Log::$level($message, $context);
        }
    }

    private function _getOptions(): array
    {
        $options = $this->options;
        $options += [
            'uniqueIdLength' => 6,
            'isCallName'     => true,
            'isMemory'       => false,
            'channelName'    => null,
        ];
        return $options;
    }

    private function _getPrefix(array $options): string
    {
        $rows = [];

        //
        if ($uniqueIdLength = $options['uniqueIdLength']) {
            $rows[] = $this->_getUniqueId($uniqueIdLength);
        }

        if ($options['isMemory']) {
            $rows[] = $this->_getMemoryUsed();
        }

        if ($options['isCallName']) {
            $class = null;
            $func = null;
            foreach ((new Exception())->getTrace() as $row) {
                if (isset($row['class'])) {
                    if ($row['class'] == __CLASS__) {
                        continue;
                    }
                    $class = $row['class'];
                    break;
                } elseif (isset($row['function'])) {
                    $func = $row['function'];
                    break;
                } else {
                    continue;
                }
            }
            //
            if ($class) {
                $tmp = explode('\\', $class);
                $rows[] = sprintf("%-31s", array_pop($tmp));
            } elseif ($func) {
                $rows[] = $func;
            } else {
                $rows[] = 'unknown';
            }
        }

        //
        // return join(',', $rows) . ',';
        return '[' . join('][', $rows) . ']';
    }

    private function _getUniqueId(int $uniqueIdLength): string
    {
        static $uniqueId;
        if ($uniqueId) {
            return $uniqueId;
        }

        $offset = -abs($uniqueIdLength);
        $uniqueId = substr(uniqid(), $offset);
        return $uniqueId;
    }

    /**
     * 小數 無條件捨去
     */
    private function _getMemoryUsed(): string
    {
        $value = floor(memory_get_peak_usage(true) / 1024 / 1024) . "M";
        return sprintf("%4s", $value);
    }
}
