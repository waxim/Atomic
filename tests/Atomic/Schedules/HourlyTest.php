<?php

namespace Atomic\Tests;

use DateTime;
use PHPUnit_Framework_TestCase as TestCase;

class HourlyTest extends TestCase
{
    protected $schedule = 'hourly';

    public function testAHourlyScheduleWillMake()
    {
        $hourly = new \Atomic\Schedule\Hourly(new DateTime());
        $this->assertSame($hourly->getName(), 'hourly');
    }

    public function testAHourlyFunctionWillRun()
    {
        $hourly = new \Atomic\Schedule\Hourly(new DateTime('9am'));
        $event = new \Atomic\Event('test', $hourly, function () {
            return 'This works every hour';
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime('10am'));

        $this->assertSame($return, 'This works every hour');
    }

    public function testAHourlyFunctionWontRun()
    {
        $hourly = new \Atomic\Schedule\Hourly(new DateTime('9am'));
        $event = new \Atomic\Event('test', $hourly, function () {
            return 'This works every hour';
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime('8am'));

        $this->assertNull($return);
    }
}
