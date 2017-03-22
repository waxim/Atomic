<?php

namespace Atomic\Schedule;

class Yearly extends \Atomic\Schedule implements ScheduleInterface
{
    /**
     * The "date" string format to compare.
     *
     * @var string
     */
    protected $compare_format = 'dM';

    /**
     * Hold our name.
     *
     * @var string
     */
    protected $name = 'yearly';

    /**
     * Hold our DateInterval format.
     *
     * @string
     */
    protected $interval_format = 'P1Y';
}
