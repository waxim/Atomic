<?php

namespace Atomic\Tests;

use Atomic\Event\Mapper;
use PHPUnit_Framework_TestCase as TestCase;

class MapperTest extends TestCase
{
    public $map = [
        'name'      => 'name',
        'callback'  => 'task',
        'schedule'  => 'schedule',
        'first_run' => 'first_run',
    ];

    public function getTestEvents()
    {
        return [
            [
                'name'     => 'my-event',
                'schedule' => 'daily',
                'task'     => function () {
                    return 'test';
                },
                'first_run' => '12-12-2012',
            ],
            [
                'name'     => 'my-event-2',
                'schedule' => 'daily',
                'task'     => function () {
                    return 'test 2';
                },
                'first_run' => '12-12-2012',
            ],
        ];
    }

    public function testCanMapArray()
    {
        $mapper = new Mapper($this->getTestEvents(), $this->map);
        $stack = $mapper->getStack();

        $this->assertSame($stack->count(), 2);
    }

    public function testCanGetAFunctionFromTheStack()
    {
        $mapper = new Mapper($this->getTestEvents(), $this->map);
        $stack = $mapper->getStack();

        $event = $stack->getTopOfStack();

        $this->assertSame($event->fire(), 'test');
    }

    /**
     * @expectedException Atomic\Exceptions\MissingMapFields
     */
    public function testWillThrowMissingFields()
    {
        $mapper = new Mapper($this->getTestEvents(), ['name']);
        $stack = $mapper->getStack();

        $this->assertSame($stack->count(), 2);
    }

    /**
     * @expectedException Atomic\Exceptions\CallbackCantBeCalled
     */
    public function testWillThrowNotCallable()
    {
        $event = [
            'name'      => 'broken-event',
            'task'      => null,
            'schedule'  => 'daily',
            'first_run' => '12-12-2012',
        ];

        $mapper = new Mapper([$event], $this->map);
        $stack = $mapper->getStack();

        $this->assertSame($stack->count(), 2);
    }

    /**
     * @expectedException Atomic\Exceptions\ScheduleNotFound
     */
    public function testWillThrowNoSchedule()
    {
        $event = [
            'name' => 'broken-event',
            'task' => function () {
                return 'test';
            },
            'schedule'  => 'every-wednesday',
            'first_run' => '12-12-2012',
        ];

        $mapper = new Mapper([$event], $this->map);
        $stack = $mapper->getStack();

        $this->assertSame($stack->count(), 2);
    }
}
