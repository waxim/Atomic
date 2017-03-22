<?php

namespace Atomic\Event;

use Atomic\Event;
use Atomic\Exceptions\CallbackCantBeCalled;
use Atomic\Exceptions\MissingMapFields;
use Atomic\Exceptions\ScheduleNotFound;
use Atomic\Schedule as Schedule;
use DateTime;

class Mapper
{
    /**
     * Our field name constants.
     */
    const NAME_KEY = 'name';
    const CALLBACK_KEY = 'callback';
    const SCHEDULE_KEY = 'schedule';
    const FIRSTRUN_KEY = 'first_run';

    /**
     * Hold our original data.
     *
     * @var array
     */
    private $data;

    /**
     * Hold all our Event objects.
     *
     * @var array
     */
    private $events = [];

    /**
     * Hold field maps.
     *
     * @var array
     */
    private $map;

    /**
     * Hold our stack.
     *
     * @var array
     */
    private $stack;

    /**
     * The fields required for field map.
     *
     * @var array
     */
    protected $required = [self::NAME_KEY, self::CALLBACK_KEY, self::SCHEDULE_KEY, self::FIRSTRUN_KEY];

    /**
     * Map our schedule words to classes.
     *
     * @var array
     */
    private $schedule_map = [
        'minute'  => Minute::class,
        'hourly'  => Hourly::class,
        'daily'   => Schedule\Daily::class,
        'weekly'  => Weekly::class,
        'monthly' => Monthly::class,
        'yearly'  => Yearly::class,
    ];

    /**
     * Build our stack and return it.
     *
     * @param array $data
     * @param array $field_map
     *
     * @throws MissingMapFields
     * @throws CallbackCantBeCalled
     * @throws ScheduleNotFound
     *
     * @return void
     */
    public function __construct(array $data, array $field_map = null)
    {
        $fields = $field_map ? $field_map : $this->getRequired();
        if ((array_keys($fields) != $this->getRequired())) {
            throw new MissingMapFields();
        }

        $this->map = $field_map;

        foreach ($data as $event) {
            if (!is_callable($event[$this->getFieldFromMap(self::CALLBACK_KEY)])) {
                throw new CallbackCantBeCalled();
            }

            if (!in_array($event[$this->getFieldFromMap(self::SCHEDULE_KEY)], array_keys($this->schedule_map))) {
                throw new ScheduleNotFound();
            }

            $evnt = $this->buildNewEvent($event);
            array_push($this->events, $evnt);
        }

        $this->stack = new Stack($this->events);
    }

    /**
     * Take an array and make our event.
     *
     * @param $array
     *
     * @return Event
     */
    private function buildNewEvent(array $event)
    {
        $schedule = $this->getSchedule(
            $event[$this->getFieldFromMap(self::SCHEDULE_KEY)],
            $event[$this->getFieldFromMap(self::FIRSTRUN_KEY)]
        );

        return new Event(
            $event[$this->getFieldFromMap(self::NAME_KEY)],
            $schedule,
            $event[$this->getFieldFromMap(self::CALLBACK_KEY)]
        );
    }

    /**
     * Return our require array.
     *
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Get our schedule class.
     *
     * @return callable
     */
    public function getSchedule($class_key, $first_run)
    {
        $class = $this->schedule_map[$class_key];

        return new $class(new DateTime($first_run));
    }

    /**
     * Get our field key from our map.
     *
     * @param string $field
     *
     * @return string
     */
    public function getFieldFromMap($field)
    {
        return $this->map[$field];
    }

    /**
     * Return our stack.
     *
     * @return Stack
     */
    public function getStack()
    {
        return $this->stack;
    }
}
