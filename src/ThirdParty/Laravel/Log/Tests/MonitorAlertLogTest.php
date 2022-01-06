<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Ydin\ThirdParty\Laravel\Log\MonitorAlertLog;

final class MonitorAlertLogTest extends TestCase
{
    /**
     * @var Mockery\Mock
     */
    protected $monitor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->monitor = \Mockery::mock(MonitorAlertLog::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $this->monitor->resetDefaultValues();
        $this->monitor
            ->shouldReceive('log')
            ->once();
    }

    // --------------------------------------------------------------------------------
    //  memory
    // --------------------------------------------------------------------------------

    /**
     * @test
     */
    public function memory_limit_is_safe()
    {
        $this->monitor
            ->shouldReceive('getMemoryUsedMegabyte')
            ->once()
            ->andReturn(9);

        $this->monitor->watch('hello', [
            'memoryLimit' => 10,
        ]);

        $information = $this->monitor->makeAlertInfos();
        $this->assertEquals(false, isset($information['excessive_memory_usage_100_MB']));
        $this->assertEquals(false, isset($information['too_much_memory_usage']));
    }

    /**
     * @test
     */
    public function memory_limit_is_excessive()
    {
        $this->monitor
            ->shouldReceive('getMemoryUsedMegabyte')
            ->once()
            ->andReturn(10);

        $this->monitor->watch('hello', [
            'memoryLimit' => 10,
        ]);

        $information = $this->monitor->makeAlertInfos();
        $this->assertEquals(false, isset($information['excessive_memory_usage_100_MB']));
        $this->assertEquals('10 MB', $information['too_much_memory_usage']);
    }

    /**
     * @test
     */
    public function excessive_memory_usage_100_mb_should_work()
    {
        $this->monitor
            ->shouldReceive('getMemoryUsedMegabyte')
            ->once()
            ->andReturn(100);

        $this->monitor->watch('hello');

        $information = $this->monitor->makeAlertInfos();
        $this->assertEquals(1, $information['excessive_memory_usage_100_MB']);
        $this->assertEquals('100 MB', $information['too_much_memory_usage']);
    }

    /**
     * @test
     */
    public function excessive_memory_usage_100_mb_should_not_work()
    {
        $this->monitor
            ->shouldReceive('getMemoryUsedMegabyte')
            ->once()
            ->andReturn(99);

        $this->monitor->watch('hello');

        $information = $this->monitor->makeAlertInfos();
        $this->assertEquals(false, isset($information['excessive_memory_usage_100_MB']));
        $this->assertEquals('99 MB', $information['too_much_memory_usage']);
    }

    // --------------------------------------------------------------------------------
    //  execute times
    // --------------------------------------------------------------------------------

    /**
     * @test
     */
    public function execute_time_limit_is_safe()
    {
        $this->monitor
            ->shouldReceive('getTimeDiff')
            ->once()
            ->andReturn(9);

        $this->monitor->watch('hello', [
            'executeTimeLimit' => 10,
        ]);

        $information = $this->monitor->makeAlertInfos();
        $this->assertEquals(false, isset($information['execution_time_exceeds_1_minute_and_30_seconds']));
        $this->assertEquals(false, isset($information['execution_time_is_too_long']));
    }

    /**
     * @test
     */
    public function execute_time_limit_is_over_time()
    {
        $this->monitor
            ->shouldReceive('getTimeDiff')
            ->once()
            ->andReturn(10);

        $this->monitor->watch('hello', [
            'executeTimeLimit' => 10,
        ]);

        $information = $this->monitor->makeAlertInfos();
        $this->assertEquals(false, isset($information['execution_time_exceeds_1_minute_and_30_seconds']));
        $this->assertEquals(10, isset($information['execution_time_is_too_long']));
    }

    /**
     * @test
     */
    public function execution_time_exceeds_1_minute_and_30_seconds_should_work()
    {
        $this->monitor
            ->shouldReceive('getTimeDiff')
            ->once()
            ->andReturn(90);

        $this->monitor->watch('hello');

        $information = $this->monitor->makeAlertInfos();
        $this->assertEquals(1, $information['execution_time_exceeds_1_minute_and_30_seconds']);
        $this->assertEquals(90, $information['execution_time_is_too_long']);
    }

    /**
     * @test
     */
    public function execution_time_exceeds_1_minute_and_30_seconds_should_not_work()
    {
        $this->monitor
            ->shouldReceive('getTimeDiff')
            ->once()
            ->andReturn(89);

        $this->monitor->watch('hello');

        $information = $this->monitor->makeAlertInfos();
        $this->assertEquals(false, isset($information['execution_time_exceeds_1_minute_and_30_seconds']));
        $this->assertEquals(89, $information['execution_time_is_too_long']);
    }
}
