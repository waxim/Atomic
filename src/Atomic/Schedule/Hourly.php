<?php

namespace Atomic\Schedule;

class Hourly extends \Atomic\Schedule implements ScheduleInterface
{

    /**
     * The "date" string format to compare.
     *
     * @var string
     */
    protected $compare_format = "Hi";

    /**
     * Hold our name.
     *
     * @var string
     */
    protected $name = "hourly";

    /**
     * Hold our DateInterval format
     *
     * @string
     */
    protected $interval_format = "PT1H";
}
