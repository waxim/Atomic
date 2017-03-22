<?php

namespace Atomic\Schedule;

class Monthly extends \Atomic\Schedule implements ScheduleInterface
{
    /**
     * The "date" string format to compare.
     *
     * @var string
     */
    protected $compare_format = 'd';

    /**
     * Hold our name.
     *
     * @var string
     */
    protected $name = 'monthly';

    /**
     * Hold our DateInterval format.
     *
     * @string
     */
    protected $interval_format = 'P1M';
}
