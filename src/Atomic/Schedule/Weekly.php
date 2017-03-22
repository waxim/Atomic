<?php

namespace Atomic\Schedule;

class Weekly extends \Atomic\Schedule implements ScheduleInterface
{
    /**
     * The "date" string format to compare.
     *
     * @var string
     */
    protected $compare_format = 'DHI';

    /**
     * Hold our name.
     *
     * @var string
     */
    protected $name = 'weekly';

    /**
     * Hold our DateInterval format.
     *
     * @string
     */
    protected $interval_format = 'P7D';
}
