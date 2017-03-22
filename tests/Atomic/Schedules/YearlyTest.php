<?php

namespace Atomic\Tests;

use PHPUnit\Framework\TestCase;
use DateTime;

class YearlyTest extends TestCase
{

    protected $schedule = "yearly";

    public function testAYearlyScheduleWillMake()
    {
        $yearly = new \Atomic\Schedule\Yearly(new DateTime());
        $this->assertSame($yearly->getName(), "yearly");
    }

    public function testAYearlyFunctionWillRun()
    {
        $yearly = new \Atomic\Schedule\Yearly(new DateTime("1st Dec"));
        $event = new \Atomic\Event("test", $yearly, function () {
            return "This works on 1st dec every year";
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime("1st Dec 2012"));

        $this->assertSame($return, "This works on 1st dec every year");
    }

    public function testAYearlyFunctionWontRun()
    {
        $yearly = new \Atomic\Schedule\Yearly(new DateTime("1st Dec"));
        $event = new \Atomic\Event("test", $yearly, function () {
            return "This works on 1st dec every year";
        });

        $stack = new \Atomic\Event\Stack([$event]);
        $return = $stack->trigger(new DateTime("2nd Feb 2021"));

        $this->assertNull($return);
    }
}
