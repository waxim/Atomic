<?php

namespace Atomic;

use DateTime;

class Event
{
    /**
     * Hold the "name" of our event.
     *
     * @var string
     */
    private $name;

    /**
     * Hold the callback function
     *
     * @var callable
     */
    private $callback;

    /**
     * Hold the start time of our event
     *
     * @var DateTime
     */
    private $time;

    /**
     * Hold the schedule of our event.
     *
     * @var Schedule
     */
    private $schedule;

    /**
     * Build a new event.
     *
     * @param string     $name
     * @param callable   $callback
     * @param optional|DateTime   $time
     * @param optionsal|Schedule   $schedule
     *
     * @return void
     */
    public function __construct($name, Schedule\ScheduleInterface $schedule, callable $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->schedule = $schedule;

        return;
    }

    /**
     * Get our event name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return our schedule object.
     *
     * @return Schedule
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Trigger our callback, return its value.
     *
     * @return mixed
     */
    public function fire()
    {
        return call_user_func($this->callback);
    }

    /**
     * Will ask schedule if we're due to run.
     *
     * @param  null|DateTime $time
     * @return boolean
     */
    public function isDue(DateTime $time = null)
    {
        return $this->schedule ? $this->schedule->isNow($time) : false;
    }
}
