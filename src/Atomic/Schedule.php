<?php

namespace Atomic;

use DateInterval;
use DateTime;

class Schedule
{
    /**
     * Hold first time.
     *
     * @var DateTime
     */
    protected $time;

    /**
     * Holds our interval.
     *
     * @var DateInterval
     */
    protected $interval;

    /**
     * When does this event run?
     *
     * @param DateTime $time
     *
     * @return void
     */
    public function __construct(DateTime $time)
    {
        $this->time = $time;
        $this->interval = new DateInterval($this->interval_format);
    }

    /**
     * Get our name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return a DateTime of next due event.
     *
     * @return DateTime
     */
    public function getNextRun()
    {
        $date = $this->time;

        return $date->add($this->getDateInterval());
    }

    /**
     * Return a DateTime of first event.
     *
     * @return DateTime
     */
    public function getFirstRun()
    {
        return $this->time;
    }

    /**
     * Return our DateInterval.
     *
     * @return DateInterval
     */
    public function getDateInterval()
    {
        return $this->interval;
    }

    /**
     * A bool check for if we're due now.
     *
     * @return bool
     */
    public function isNow(DateTime $time = null)
    {
        $first = $time ? $time : $this->getFirstRun();
        $next = $this->getNextRun();

        return $first->format($this->compare_format) == $next->format($this->compare_format);
    }
}
