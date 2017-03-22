<?php

namespace Atomic\Tests;

use DateTime;
use PHPUnit_Framework_TestCase as TestCase;

class WeeklyTest extends TestCase
{
    protected $schedule = 'weekly';

    public function testAWeeklyScheduleWillMake()
    {
        $weekly = new \Atomic\Schedule\Weekly(new DateTime());
        $this->assertSame($weekly->getName(), 'weekly');
    }

    public function testAWeeklyFunctionWillRun()
    {
        $weekly = new \Atomic\Schedule\Weekly(new DateTime());
        $event = new \Atomic\Event('test', $weekly, function () {
            return 'This works';
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger();

        $this->assertSame($return, 'This works');
    }

    public function testAWeeklyFunctionWillNotRun()
    {
        $weekly = new \Atomic\Schedule\Weekly(new DateTime());
        $event = new \Atomic\Event('test', $weekly, function () {
            return 'This works';
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime('tomorrow'));

        $this->assertNull($return);
    }
}
