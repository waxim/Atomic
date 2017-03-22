<?php

namespace Atomic\Exceptions;

class ScheduleNotFound extends \Exception
{
    protected $message = "The schedule value you gave would not map to a valid class.";
}
