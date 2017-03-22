<?php

namespace Atomic\Event;

use Atomic\Event;
use DateTime;

class Stack
{
    /**
     * Our events stack.
     *
     * @var array
     */
    private $events = [];

    /**
     * add events to our stack.
     *
     * @param array $events
     */
    public function __construct(array $events = [])
    {
        $this->events = array_merge($this->events, $events);
    }

    /**
     * Will get the next event.
     *
     * @param DateTime $now
     *
     * @return mixed
     */
    public function trigger(DateTime $now = null)
    {
        if (!$now) {
            $now = new DateTime();
        }

        $event = $this->getNextEvent($now);

        return $event instanceof Event ? $event->fire() : null;
    }

    /**
     * Will collect the next event.
     *
     * @param DateTime $now
     *
     * @return Event
     */
    public function getNextEvent(DateTime $now)
    {
        foreach ($this->events as $index => $event) {
            if ($event->isDue($now)) {
                unset($index);

                return $event;
            }
        }

        return false;
    }

    /**
     * Will return the count of our stack.
     *
     * @return int
     */
    public function count()
    {
        return count($this->events);
    }

    /**
     * Get top (0) event off stack.
     *
     * @return Event
     */
    public function getTopOfStack()
    {
        return isset($this->events[0]) ? $this->events[0] : null;
    }
}
