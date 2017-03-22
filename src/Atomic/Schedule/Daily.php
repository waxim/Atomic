<?php

namespace Atomic\Schedule;

class Daily extends \Atomic\Schedule implements ScheduleInterface
{

    /**
     * The "date" string format to compare.
     *
     * @var string
     */
    protected $compare_format = "HI";

    /**
     * Hold our name.
     *
     * @var string
     */
    protected $name = "daily";

    /**
     * Hold our DateInterval format
     *
     * @string
     */
    protected $interval_format = "P1D";
}
