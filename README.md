[![StyleCI](https://styleci.io/repos/85839959/shield?branch=master)](https://styleci.io/repos/85839959) [![Build Status](https://travis-ci.org/waxim/Atomic.svg?branch=master)](https://travis-ci.org/waxim/Atomic)
# Atomic

Atomic is a PHP schedule library, events can be build and scheduled. You may use Atomic simply to schedule your events, or you can attach an adapter and use our bin provided to run your jobs based on a cron schedule.


## Schedule a job
```php
# Schedule an event on the first of december each year.
$yearly = new Atomic\Schedule\Yearly(new DateTime("1st December"));

$event = new Atomic\Event("dec-log-clear", $yearly, function() {
    Logs::clearAll(); // hypothetical event code.
});

# Some check at a later time
if ($event->isDue()) {
    $event->fire();
}
```

## Stacks
If you like you can register all your events no a stack and have the stack fire any events as they are due.

```php
$stack = new Atomic\Event\Stack([$event, $event2, $event3]);
$evnt = $stack->getNextEvent();

if ($evnt) {
    Log::info("Triggering event " . $evnt->getName());
    $result = $evnt->fire();
    Log::info("Event Return: " . $result);
}
```

If you dont need to care about extra event data besides its return value you can just ask the stack to trigger the events for you, if it finds an event it will run it, if not it will return false.

```php
$return = $stack->trigger();
if ($return) {
    Log::info("Oh, we fired an event. It returned: " . $return);
} else {
    Log::info("No events found.");
}
```

## Mappers
We provide a simple mapper, which will take an array of events return a stack. This is handy if you store events in a database table and you want to load that into a stack.

```php
try {
    $mapper = new Atomic\Event\Mapper($events, [
        'name'      => 'name',
        'schedule'  => 'schedule',
        'callback'  => 'callback',
        'first_run' => 'start_time'
    ]);

    $stack = $mapper->getStack();
    $stack->trigger();

} catch (Exception $e) {
    Log::warn($e->getMessage());
}
```

## Custom Schedules
You can add your own schedules quite simply by using the `ScheduleInterface` your schedule must accept a datetime on construct and it must return a true or false on `isNow` if this function returns true a stack will fire this event.

This class would trigger your function Every Wednesday.
```php
namespace Custom\Schedule;

class EveryWednesday implements \Atomic\Schedule\ScheduleInterface
{
    public function __construct(DateTime $time)
    {
        return true;
    }

    public function getName()
    {
        return "Every Wednesday";
    }

    public function getNextRun()
    {
        return new DateTime("Wednesday");
    }

    public function getFirstRun()
    {
        return new DateTime("Wednesday");
    }

    public function isNow(DateTime $time)
    {
        return date("D") == "Wed";
    }
}

```

## Install
```
composer require waxim/atomic
```

## Test
```
phpunit
```
