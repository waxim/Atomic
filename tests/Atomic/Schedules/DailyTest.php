<?php

namespace Atomic\Tests;

use DateTime;
use PHPUnit_Framework_TestCase as TestCase;

class DailyTest extends TestCase
{
    protected $schedule = 'daily';

    public function testADailyScheduleWillMake()
    {
        $daily = new \Atomic\Schedule\Daily(new DateTime());
        $this->assertSame($daily->getName(), 'daily');
    }

    public function testADailyFunctionWillRun()
    {
        $daily = new \Atomic\Schedule\Daily(new DateTime('11pm'));
        $event = new \Atomic\Event('test', $daily, function () {
            return 'This works at 11pm';
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime('11pm'));

        $this->assertSame($return, 'This works at 11pm');
    }

    public function testADailyFunctionWontRun()
    {
        $daily = new \Atomic\Schedule\Daily(new DateTime('11pm'));
        $event = new \Atomic\Event('test', $daily, function () {
            return 'This works at 11pm';
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime('12pm'));

        $this->assertNull($return);
    }
}
