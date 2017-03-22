<?php

namespace Atomic\Exceptions;

class MissingMapFields extends \Exception
{
    protected $message = "The map array was missing required fields.";
}
