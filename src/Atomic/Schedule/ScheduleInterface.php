<?php

namespace Atomic\Schedule;

use DateTime;

interface ScheduleInterface
{
    /**
     * We must have a constructor that receives
     * a DateTime object.
     *
     * Our datetime object is the "first" run,
     * based on this, this class should work out
     * its cycle and have isNow return true/false
     *
     * @return void
     */
    public function __construct(DateTime $time);

    /**
     * Returns the name of the schedule.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns DateTime object of next run.
     *
     * @return DateTime $time
     */
    public function getNextRun();

    /**
     * Returns DateTime object of the first run.
     *
     * @return DateTime $time
     */
    public function getFirstRun();

    /**
     * Is this schedule due now?
     *
     * If we have a datetime, test against
     * that instead of now. This allows us
     * to simulate events.
     *
     * @param null|DateTime $time
     *
     * @return bool
     */
    public function isNow(DateTime $time);
}
