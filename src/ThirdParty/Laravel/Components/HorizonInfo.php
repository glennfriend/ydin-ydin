<?php

declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Components;

use DateTime;
use DateTimeZone;
use Exception;
use Laravel\Horizon\Contracts\WorkloadRepository;
use Illuminate\Support\Facades\Log;
use Predis\Connection\ConnectionException;
use Predis\Response\ServerException;

/**
 * @version 0.1.0
 * @package Ydin\ThirdParty\Laravel\Components
 */
class HorizonInfo
{
    private static WorkloadRepository $workloadRepository;

    public static function isHorizonEnable(): bool
    {
        if (!self::getWorkload()) {
            return false;
        }
        return true;
    }

    public static function getInProgress(): array
    {
        $result = [];

        foreach (self::getWorkload() as $row) {
            if (!isset($row['length'])) {
                continue;
            }
            if ($row['length'] <= 0) {
                continue;
            }
            $result[] = [
                'name'        => $row['name'],
                'queueLength' => $row['length'],
                'processes'   => $row['processes'],
            ];
        }
        return $result;
    }

    public static function getAllProgress(): array
    {
        $result = [];
        foreach (self::getWorkload() as $row) {
            $result[] = [
                'name'        => $row['name'],
                'queueLength' => $row['length'],
                'processes'   => $row['processes'],
            ];
        }
        return $result;
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    protected static function getWorkload(): array
    {
        static::$workloadRepository = app(WorkloadRepository::class);

        return collect(self::$workloadRepository->get())
            ->sortBy('name')
            ->values()
            ->toArray();
    }
}
