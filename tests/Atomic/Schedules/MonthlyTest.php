<?php

namespace Atomic\Tests;

use PHPUnit\Framework\TestCase;
use DateTime;

class MonthlyTest extends TestCase
{

    protected $schedule = "monthly";

    public function testAMonthlyScheduleWillMake()
    {
        $daily = new \Atomic\Schedule\Monthly(new DateTime());
        $this->assertSame($daily->getName(), "monthly");
    }

    public function testAMonthlyFunctionWillRun()
    {
        $daily = new \Atomic\Schedule\Monthly(new DateTime("1st Dec"));
        $event = new \Atomic\Event("test", $daily, function () {
            return "This works on 1st dec";
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime("1st Jan"));

        $this->assertSame($return, "This works on 1st dec");
    }

    public function testAMonthlyFunctionWontRun()
    {
        $daily = new \Atomic\Schedule\Monthly(new DateTime("1st Dec"));
        $event = new \Atomic\Event("test", $daily, function () {
            return "This works on 1st dec";
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime("2nd Dec"));

        $this->assertNull($return);
    }
}
